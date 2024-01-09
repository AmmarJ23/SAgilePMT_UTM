<?php

namespace App\Http\Controllers;
use App\Task;
use App\Sprint;
use App\Status;
use Illuminate\Http\Request;
use App\User;

class BurnDownChartController extends Controller
{
    public function index($proj_id, $sprint_id)
    {
        
        $tasks = Task::where('sprint_id', $sprint_id)->get(['start_date','end_date','status_id']);
        $sprint = Sprint::where("sprint_id", $sprint_id)->first();
        $statuses = Status::where('project_id', $proj_id)->get();
        $user = \Auth::user();
        $countryName = $user->country;
        //var_dump($countryName);

        $sprintName = $sprint->sprint_name;
        $start_date = $sprint->start_sprint;
        $end_date = $sprint->end_sprint;
        $timezone = $this->getTimeZone($countryName);
        $currentDate = now()->timezone($timezone);
        // var_dump($timezone);

        if ($this->isBeforeStartDate($start_date, $currentDate)) {

            $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);
            $sprint->idealHoursPerDay = $idealData;
            $sprint->save();
            //$actualData = array(144,144,144,); 
            //$actualDataHoursSpent = array($this->calcTotalHoursAssigned($tasks));
            $actualData = array($this->calcTotalHoursAssigned($tasks));
            $hoursSpent = array_fill(0, count($idealData), 0);
            

            // var_dump($idealData);
            // var_dump($actualData);
        
            return view('testBurnDown.index', compact('idealData','actualData','hoursSpent', 'sprintName'),['start_date' => $start_date, 'end_date' => $end_date]);

        }else if ($this->isBeforeEndDate($end_date, $currentDate)){

            $idealData = $sprint->idealHoursPerDay ? json_decode($sprint->idealHoursPerDay, true) : [];

            if(empty($idealData) || array_sum($idealData) == 0){

                $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);
                $sprint->idealHoursPerDay = $idealData;
                $sprint->save();
            }
            $dayZero = reset($idealData);

            $actualData =  $sprint->actualHoursPerDay ? json_decode($sprint->actualHoursPerDay, true) : [];
            $hoursSpent =  $sprint->hoursSpent ? json_decode($sprint->hoursSpent, true) : [];
            $actualDataHoursSpent =  $this->calculateActualLineHoursLine($start_date,$end_date,$actualData,$hoursSpent,$tasks,$statuses,$dayZero,$currentDate);
            $actualData =  $actualDataHoursSpent['actualData'];
            $hoursSpent = $actualDataHoursSpent['hoursSpent'];
            //$actualData =  $this->calculateActualLine($start_date,$end_date,$actualData,$tasks,$statuses,$dayZero,$currentDate);
            $sprint->actualHoursPerDay = $actualData;
            $sprint->hoursSpent =  $hoursSpent;
            $sprint->save();
    
            //$actualData = array(96,120,72,72,48,0); 
            // var_dump($idealData); 
            // var_dump($actualData);
            // var_dump($hoursSpent);

            return view('testBurnDown.index', compact('idealData','actualData','hoursSpent', 'sprintName'),['start_date' => $start_date, 'end_date' => $end_date]);
        }else{

            $idealData = $sprint->idealHoursPerDay ? json_decode($sprint->idealHoursPerDay, true) : [];
            $actualData = $sprint->actualHoursPerDay ? json_decode($sprint->actualHoursPerDay, true) : [];
            $hoursSpent = $sprint->hoursSpent ? json_decode($sprint->hoursSpent, true) : [];

            if(empty($idealData)){
                $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);
                $sprint->idealHoursPerDay = $idealData;
                $sprint->save();
            }

            if(empty($actualData) || empty($hoursSpent)){
                $actualData = array($this->calcTotalHoursAssigned($tasks));
                $hoursSpent = array_fill(0, count($idealData), 0);
            }

            //$actualData = array(146,146,146,); 
            // var_dump($idealData);
            // var_dump($actualData);
            // var_dump($hoursSpent);

            return view('testBurnDown.index', compact('idealData','actualData','hoursSpent', 'sprintName'),['start_date' => $start_date, 'end_date' => $end_date]);
        }

    }

    public function isBeforeStartDate($startDate, $currentDate)
    {
        return strtotime($currentDate) < strtotime($startDate);
    }

    public function isBeforeEndDate($end_date, $currentDate)
    {
        return strtotime($currentDate) < strtotime($end_date);
    }

    public function calculateIdealDataForTasks($tasks,$sprint)
    {

        $totalHoursAssigned = $this ->calcTotalHoursAssigned($tasks);

        $idealData = [];
        $start_date = strtotime($sprint->start_sprint);
        $end_date = strtotime($sprint->end_sprint);
        $sprintDuration = max(1, ($end_date - $start_date) / (60 * 60 * 24)) + 1; // Avoid division by zero

        $idealHoursPerDay =  $totalHoursAssigned / $sprintDuration;

        $currentDate = $start_date;

        $idealData[] = $totalHoursAssigned;

        for ($day = 1; $day < $sprintDuration +1; $day++) {
            $totalHoursAssigned -= $idealHoursPerDay;
            $idealData[] = max(0, $totalHoursAssigned);
            $currentDate += 24 * 60 * 60; // Move to the next day (in seconds)
        }


        return $idealData;
    }

    public function calcTotalHoursAssigned($tasks){

        $totalHoursAssigned =0;
        
        foreach ($tasks as $task) {
            $startDateTime = strtotime($task->start_date)/ 3600;
            $endDateTime = strtotime($task->end_date)/ 3600;

            if ($startDateTime <= $endDateTime && $endDateTime >= $startDateTime) {
                // Calculate the total hours within the date range for the task
                $totalHoursAssigned += $this->calculateTotalHoursWithinRange($startDateTime, $endDateTime);
            }
        }

        return $totalHoursAssigned;

    }

    public function calculateTotalHoursWithinRange($startDateTime, $endDateTime) {
        // Calculate the difference in hours between start and end date
        $hoursWithinRange = $endDateTime - $startDateTime;
        return $hoursWithinRange;
    }

    public function calculateActualLineHoursLine($startDate, $endDate, $actualData, $hoursSpent, $tasks, $statuses,$dayZero,$currentDate)
    {
        $startDateTime = strtotime($startDate);
        $endDateTime = strtotime($endDate);

        $daysDifferenceStartCurrent = floor((strtotime($currentDate) - $startDateTime) / (60 * 60 * 24));
        $daysDifferenceStartCurrent = $daysDifferenceStartCurrent + 2;
        $totalHoursAssigned = $this ->calcTotalHoursAssigned($tasks);
        // var_dump(" currentDate: " . $currentDate);
        // var_dump(" startDateTime: " . $startDate);


        if(empty($actualData) ||array_sum($actualData) == 0){
            //$actualData = [$totalHoursAssigned];
            $actualData[0] = $dayZero;
            $actualData[1] = $totalHoursAssigned;
            $hoursSpent[0] = 0;
            $hoursSpent[1] = 0;
            //$daysDifferenceStartCurrent = $daysDifferenceStartCurrent + 1;
        }

        $taskDone = collect(); // Initialize an empty collection
        $taskNotDone = collect();
        
        foreach($tasks as $task){

            $status = $statuses->firstWhere('id', $task->status_id);
            $statusTitle = strtolower($status->title);
            
            if($statusTitle == "done"){
                $taskDone->add($task); // Add the task to the collection
            }
            else{
                $taskNotDone->add($task);;
            }

        }

        // Check if there are no done tasks
        $doneTaskHours = 0;
        $doneHoursSpent = 0;

        if (!$taskDone->isEmpty()) {
            //$doneTaskHours = 0;
            foreach ($taskDone as $task) {

                $taskStartDateTimeHours = strtotime($task->start_date)/ 3600; //hours
                $taskEndDateTimeHours = strtotime($task->end_date)/ 3600;
                $taskStartDateTime = $task->start_date;
                $taskEndDatetime = $task->end_date;
                $currentDateHours = $currentDate->timestamp / 3600;

                //var_dump("Start: " . $taskStartDateTimeHours . ", End: " . $taskStartDateTimeHours . ", Current: " . $currentDateHours );
                
                $doneTaskHours += $this->calculateTotalHoursWithinRange($taskStartDateTimeHours, $taskEndDateTimeHours);
                $doneHoursSpent += $this->calculateTotalHoursWithinRange($taskStartDateTimeHours, $taskEndDateTimeHours);

            }
            
        } 

        // var_dump("Calculated doneTaskHours: " . $doneTaskHours);
        // var_dump("Calculated doneHoursSpent: " . $doneHoursSpent);
        // var_dump("Calculated totalHoursAssigned: " . $totalHoursAssigned);
        $totalHoursLeft = $totalHoursAssigned - $doneTaskHours;
        // var_dump("Calculated totalHoursLeft: " . $totalHoursLeft);

        if($taskNotDone->isEmpty()){
            $totalHoursLeft = 0;
        }

        $countArray = count($actualData);
        $lastArray = count($actualData) - 1;
        $lastDay = end($actualData);
        $lastHours =  end($hoursSpent);
        //$daysDifferenceStartCurrent = $daysDifferenceStartCurrent + 2;
        $fillArray =  abs($daysDifferenceStartCurrent - $countArray);
        // var_dump("countArray: " . $countArray);
        // var_dump("daysDifferenceStartCurrent: " . $daysDifferenceStartCurrent);
        // var_dump("fillArray: " . $fillArray);

        $dayDifTemp = $daysDifferenceStartCurrent;

        if($dayDifTemp == 1){
            $dayDifTemp = $dayDifTemp + 1;
        }

        if ($countArray <= $dayDifTemp) {

            if($countArray == 2){
                for ($i = 0; $i < $daysDifferenceStartCurrent -2; $i++) {
                    $actualData[] = $lastDay;
                    $hoursSpent[] = $lastHours;
                    // var_dump("inside countArray loop");
                }
                // var_dump("inside countArray ");
            }
            else{
                for ($i = 0; $i < $fillArray; $i++) {
                    $actualData[] = $lastDay;
                    $hoursSpent[] = $lastHours;
                    // var_dump("inside fillArray loop");
                }
                // var_dump("inside fillArray ");
            }

        }

        $actualData[$lastArray] = $totalHoursLeft;
        $hoursSpent[$lastArray] = $doneHoursSpent;
        // var_dump("lastArray: " . $actualData[$lastArray]);
        // var_dump("lastHours: " . $hoursSpent[$lastArray]);

        return ['actualData' => $actualData, 'hoursSpent' => $hoursSpent];
    }

    public function getTimeZone($countryName) {
        $countryTimezones = [
            'Afghanistan' => 'Asia/Kabul',
            'Albania' => 'Europe/Tirane',
            'Algeria' => 'Africa/Algiers',
            'American Samoa' => 'Pacific/Pago_Pago',
            'Andorra' => 'Europe/Andorra',
            'Angola' => 'Africa/Luanda',
            'Anguilla' => 'America/Anguilla',
            'Antarctica' => 'Antarctica/Casey',
            'Antigua and Barbuda' => 'America/Antigua',
            'Argentina' => 'America/Argentina/Buenos_Aires',
            'Armenia' => 'Asia/Yerevan',
            'Aruba' => 'America/Aruba',
            'Australia' => 'Australia/Sydney',
            'Austria' => 'Europe/Vienna',
            'Azerbaijan' => 'Asia/Baku',
            'Bahamas' => 'America/Nassau',
            'Bahrain' => 'Asia/Bahrain',
            'Bangladesh' => 'Asia/Dhaka',
            'Barbados' => 'America/Barbados',
            'Belarus' => 'Europe/Minsk',
            'Belgium' => 'Europe/Brussels',
            'Belize' => 'America/Belize',
            'Benin' => 'Africa/Porto-Novo',
            'Bermuda' => 'Atlantic/Bermuda',
            'Bhutan' => 'Asia/Thimphu',
            'Bolivia' => 'America/La_Paz',
            'Bosnia and Herzegovina' => 'Europe/Sarajevo',
            'Botswana' => 'Africa/Gaborone',
            'Brazil' => 'America/Sao_Paulo',
            'British Indian Ocean Territory' => 'Indian/Chagos',
            'British Virgin Islands' => 'America/Tortola',
            'Brunei' => 'Asia/Brunei',
            'Bulgaria' => 'Europe/Sofia',
            'Burkina Faso' => 'Africa/Ouagadougou',
            'Burundi' => 'Africa/Bujumbura',
            'Cambodia' => 'Asia/Phnom_Penh',
            'Cameroon' => 'Africa/Douala',
            'Canada' => 'America/Toronto',
            'Cape Verde' => 'Atlantic/Cape_Verde',
            'Cayman Islands' => 'America/Cayman',
            'Central African Republic' => 'Africa/Bangui',
            'Chad' => 'Africa/Ndjamena',
            'Chile' => 'America/Santiago',
            'China' => 'Asia/Shanghai',
            'Christmas Island' => 'Indian/Christmas',
            'Cocos Islands' => 'Indian/Cocos',
            'Colombia' => 'America/Bogota',
            'Comoros' => 'Indian/Comoro',
            'Cook Islands' => 'Pacific/Rarotonga',
            'Costa Rica' => 'America/Costa_Rica',
            'Croatia' => 'Europe/Zagreb',
            'Cuba' => 'America/Havana',
            'Curacao' => 'America/Curacao',
            'Cyprus' => 'Asia/Nicosia',
            'Czech Republic' => 'Europe/Prague',
            'Democratic Republic of the Congo' => 'Africa/Kinshasa',
            'Denmark' => 'Europe/Copenhagen',
            'Djibouti' => 'Africa/Djibouti',
            'Dominica' => 'America/Dominica',
            'Dominican Republic' => 'America/Santo_Domingo',
            'East Timor' => 'Asia/Dili',
            'Ecuador' => 'America/Guayaquil',
            'Egypt' => 'Africa/Cairo',
            'El Salvador' => 'America/El_Salvador',
            'Equatorial Guinea' => 'Africa/Malabo',
            'Eritrea' => 'Africa/Asmara',
            'Estonia' => 'Europe/Tallinn',
            'Ethiopia' => 'Africa/Addis_Ababa',
            'Falkland Islands' => 'Atlantic/Stanley',
            'Faroe Islands' => 'Atlantic/Faroe',
            'Fiji' => 'Pacific/Fiji',
            'Finland' => 'Europe/Helsinki',
            'France' => 'Europe/Paris',
            'French Polynesia' => 'Pacific/Tahiti',
            'Gabon' => 'Africa/Libreville',
            'Gambia' => 'Africa/Banjul',
            'Georgia' => 'Asia/Tbilisi',
            'Germany' => 'Europe/Berlin',
            'Ghana' => 'Africa/Accra',
            'Gibraltar' => 'Europe/Gibraltar',
            'Greece' => 'Europe/Athens',
            'Greenland' => 'America/Godthab',
            'Grenada' => 'America/Grenada',
            'Guam' => 'Pacific/Guam',
            'Guatemala' => 'America/Guatemala',
            'Guernsey' => 'Europe/Guernsey',
            'Guinea' => 'Africa/Conakry',
            'Guinea-Bissau' => 'Africa/Bissau',
            'Guyana' => 'America/Guyana',
            'Haiti' => 'America/Port-au-Prince',
            'Honduras' => 'America/Tegucigalpa',
            'Hong Kong' => 'Asia/Hong_Kong',
            'Hungary' => 'Europe/Budapest',
            'Iceland' => 'Atlantic/Reykjavik',
            'India' => 'Asia/Kolkata',
            'Indonesia' => 'Asia/Jakarta',
            'Iran' => 'Asia/Tehran',
            'Iraq' => 'Asia/Baghdad',
            'Ireland' => 'Europe/Dublin',
            'Isle of Man' => 'Europe/Isle_of_Man',
            'Israel' => 'Asia/Jerusalem',
            'Italy' => 'Europe/Rome',
            'Ivory Coast' => 'Africa/Abidjan',
            'Jamaica' => 'America/Jamaica',
            'Japan' => 'Asia/Tokyo',
            'Jersey' => 'Europe/Jersey',
            'Jordan' => 'Asia/Amman',
            'Kazakhstan' => 'Asia/Almaty',
            'Kenya' => 'Africa/Nairobi',
            'Kiribati' => 'Pacific/Tarawa',
            'Kosovo' => 'Europe/Belgrade',
            'Kuwait' => 'Asia/Kuwait',
            'Kyrgyzstan' => 'Asia/Bishkek',
            'Laos' => 'Asia/Vientiane',
            'Latvia' => 'Europe/Riga',
            'Lebanon' => 'Asia/Beirut',
            'Lesotho' => 'Africa/Maseru',
            'Liberia' => 'Africa/Monrovia',
            'Libya' => 'Africa/Tripoli',
            'Liechtenstein' => 'Europe/Vaduz',
            'Lithuania' => 'Europe/Vilnius',
            'Luxembourg' => 'Europe/Luxembourg',
            'Macau' => 'Asia/Macau',
            'North Macedonia' => 'Europe/Skopje',
            'Madagascar' => 'Indian/Antananarivo',
            'Malawi' => 'Africa/Blantyre',
            'Malaysia' => 'Asia/Kuala_Lumpur',
            'Maldives' => 'Indian/Maldives',
            'Mali' => 'Africa/Bamako',
            'Malta' => 'Europe/Malta',
            'Marshall Islands' => 'Pacific/Majuro',
            'Mauritania' => 'Africa/Nouakchott',
            'Mauritius' => 'Indian/Mauritius',
            'Mayotte' => 'Indian/Mayotte',
            'Mexico' => 'America/Mexico_City',
            'Micronesia' => 'Pacific/Chuuk',
            'Moldova' => 'Europe/Chisinau',
            'Monaco' => 'Europe/Monaco',
            'Mongolia' => 'Asia/Ulaanbaatar',
            'Montenegro' => 'Europe/Podgorica',
            'Montserrat' => 'America/Montserrat',
            'Morocco' => 'Africa/Casablanca',
            'Mozambique' => 'Africa/Maputo',
            'Myanmar' => 'Asia/Yangon',
            'Namibia' => 'Africa/Windhoek',
            'Nauru' => 'Pacific/Nauru',
            'Nepal' => 'Asia/Kathmandu',
            'Netherlands' => 'Europe/Amsterdam',
            'Netherlands Antilles' => 'America/Curacao',
            'New Caledonia' => 'Pacific/Noumea',
            'New Zealand' => 'Pacific/Auckland',
            'Nicaragua' => 'America/Managua',
            'Niger' => 'Africa/Niamey',
            'Nigeria' => 'Africa/Lagos',
            'Niue' => 'Pacific/Niue',
            'North Korea' => 'Asia/Pyongyang',
            'Northern Mariana Islands' => 'Pacific/Saipan',
            'Norway' => 'Europe/Oslo',
            'Oman' => 'Asia/Muscat',
            'Pakistan' => 'Asia/Karachi',
            'Palau' => 'Pacific/Palau',
            'Palestine' => 'Asia/Gaza',
            'Panama' => 'America/Panama',
            'Papua New Guinea' => 'Pacific/Port_Moresby',
            'Paraguay' => 'America/Asuncion',
            'Peru' => 'America/Lima',
            'Philippines' => 'Asia/Manila',
            'Pitcairn' => 'Pacific/Pitcairn',
            'Poland' => 'Europe/Warsaw',
            'Portugal' => 'Europe/Lisbon',
            'Puerto Rico' => 'America/Puerto_Rico',
            'Qatar' => 'Asia/Qatar',
            'Republic of the Congo' => 'Africa/Brazzaville',
            'Reunion' => 'Indian/Reunion',
            'Romania' => 'Europe/Bucharest',
            'Russia' => 'Europe/Moscow',
            'Rwanda' => 'Africa/Kigali',
            'Saint Barthelemy' => 'America/St_Barthelemy',
            'Saint Helena' => 'Atlantic/St_Helena',
            'Saint Kitts and Nevis' => 'America/St_Kitts',
            'Saint Lucia' => 'America/St_Lucia',
            'Saint Martin' => 'America/St_Martin',
            'Saint Pierre and Miquelon' => 'America/Miquelon',
            'Saint Vincent and the Grenadines' => 'America/St_Vincent',
            'Samoa' => 'Pacific/Apia',
            'San Marino' => 'Europe/San_Marino',
            'Sao Tome and Principe' => 'Africa/Sao_Tome',
            'Saudi Arabia' => 'Asia/Riyadh',
            'Senegal' => 'Africa/Dakar',
            'Serbia' => 'Europe/Belgrade',
            'Seychelles' => 'Indian/Mahe',
            'Sierra Leone' => 'Africa/Freetown',
            'Singapore' => 'Asia/Singapore',
            'Sint Maarten' => 'America/Lower_Princes',
            'Slovakia' => 'Europe/Bratislava',
            'Slovenia' => 'Europe/Ljubljana',
            'Solomon Islands' => 'Pacific/Guadalcanal',
            'Somalia' => 'Africa/Mogadishu',
            'South Africa' => 'Africa/Johannesburg',
            'South Korea' => 'Asia/Seoul',
            'South Sudan' => 'Africa/Juba',
            'Spain' => 'Europe/Madrid',
            'Sri Lanka' => 'Asia/Colombo',
            'Sudan' => 'Africa/Khartoum',
            'Suriname' => 'America/Paramaribo',
            'Svalbard and Jan Mayen' => 'Arctic/Longyearbyen',
            'Swaziland' => 'Africa/Mbabane',
            'Sweden' => 'Europe/Stockholm',
            'Switzerland' => 'Europe/Zurich',
            'Syria' => 'Asia/Damascus',
            'Taiwan' => 'Asia/Taipei',
            'Tajikistan' => 'Asia/Dushanbe',
            'Tanzania' => 'Africa/Dar_es_Salaam',
            'Thailand' => 'Asia/Bangkok',
            'Togo' => 'Africa/Lome',
            'Tokelau' => 'Pacific/Fakaofo',
            'Tonga' => 'Pacific/Tongatapu',
            'Trinidad and Tobago' => 'America/Port_of_Spain',
            'Tunisia' => 'Africa/Tunis',
            'Turkey' => 'Europe/Istanbul',
            'Turkmenistan' => 'Asia/Ashgabat',
            'Turks and Caicos Islands' => 'America/Grand_Turk',
            'Tuvalu' => 'Pacific/Funafuti',
            'U.S. Virgin Islands' => 'America/St_Thomas',
            'Uganda' => 'Africa/Kampala',
            'Ukraine' => 'Europe/Kiev',
            'United Arab Emirates' => 'Asia/Dubai',
            'United Kingdom' => 'Europe/London',
            'United States' => 'America/New_York',
            'Uruguay' => 'America/Montevideo',
            'Uzbekistan' => 'Asia/Tashkent',
            'Vanuatu' => 'Pacific/Efate',
            'Vatican' => 'Europe/Vatican',
            'Venezuela' => 'America/Caracas',
            'Vietnam' => 'Asia/Ho_Chi_Minh',
            'Wallis and Futuna' => 'Pacific/Wallis',
            'Western Sahara' => 'Africa/El_Aaiun',
            'Yemen' => 'Asia/Aden',
            'Zambia' => 'Africa/Lusaka',
            'Zimbabwe' => 'Africa/Harare',
        ];
    
        // Default to UTC if the country is not found
        return $countryTimezones[$countryName] ?? 'UTC';
    }
    

}
