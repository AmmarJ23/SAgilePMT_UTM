@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<div class="row gy-4">
  <!-- Greetings card -->
  <div class="col-md-12 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title mb-2">Hi <strong> {{ auth()->user()->name }} </strong></h2>
        <p class="pb-0">What brings you here?</p>
        <!--<h4 class="text-primary mb-1">$42.8k</h4> -->
        <p class="mb-2 pb-1">78% of target 🚀</p>
        <a href="javascript:;" class="btn btn-sm btn-danger" style="background-color: #3f58b0;">View Profile</a>
      </div>
      <img src="{{asset('assets/img/icons/misc/triangle-light.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0" width="166" alt="triangle background">
      <!-- <img src="{{asset('assets/img/illustrations/trophy.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 mb-4 pb-2" width="83" alt="view sales"> -->
    </div>
  </div>
  <!--/ Greetings card -->

  <!-- Transactions -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
          <h1 class="card-title m-0 me-2">Team</h1>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="mdi mdi-dots-vertical mdi-24px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
              <a class="dropdown-item" href="javascript:void(0);">Update</a>
            </div>
          </div>
        </div>
        <p class="mt-3"><span class="fw-medium">Teamwork</span> is the key</p>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-3 col-4">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-primary rounded shadow">
                  <i class="mdi mdi-trending-up mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Productivity</div>
                <h6 class="mb-0">2 tasks completed</h6>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-success rounded shadow">
                  <i class="mdi mdi-account-outline mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Teams</div>
                <h6 class="mb-0">Participated in ? teams</h6>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-warning rounded shadow">
                  <i class="mdi mdi-cellphone-link mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Browser</div>
                <h6 class="mb-0">Google Chrome</h6>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-info rounded shadow">
                  <i class="mdi mdi-currency-usd mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Resources</div>
                <h6 class="mb-0">Track resources</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Transactions -->

  <div class="row gy-4">
    <!-- Event Count Over Time Chart -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-1">Calendar Events</h5>
            </div>
            <div class="card-body">
                <div id="eventChart" style="height: 350px;"></div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var eventOptions = {
                            chart: {
                                type: 'bar', // Changed to bar type
                                height: 350,
                                zoom: {
                                    enabled: false
                                }
                            },
                            series: [{
                                name: 'Event Count',
                                data: @json(array_values($countsPerMonth))
                            }],
                            xaxis: {
                                categories: @json(array_keys($countsPerMonth)),
                                labels: {
                                    rotate: -45,
                                    formatter: function (value) {
                                        return value.split(' ')[0]; // Display only the month part
                                    }
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Total Events'
                                },
                                tickAmount: 5,
                                ticks: [1, 2, 3, 4, 5]
                            },
                        };

                        var eventChart = new ApexCharts(document.querySelector("#eventChart"), eventOptions);
                        eventChart.render();
                    });
                </script>
            </div>
        </div>
    </div>

 <!-- Bug Distribution Chart -->
 <div class="col-lg-6">
  <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-1">Bug Distribution</h5>
          <!-- Dropdown Menu for Chart Type -->
          <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="chartTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  Bug Status
              </button>
              <ul class="dropdown-menu" aria-labelledby="chartTypeDropdown">
                  <li><a class="dropdown-item active" href="#" data-chart-type="status">Bug Status</a></li>
                  <li><a class="dropdown-item" href="#" data-chart-type="severity">Bug Severity</a></li>
              </ul>
          </div>
      </div>
      <div class="card-body">
          <div id="bugChart" style="height: 350px;"></div>
      </div>
  </div>
</div>

<!-- Include Bootstrap CSS (if not already included) -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Include Bootstrap JS (if not already included) -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      var chartOptions = {
          chart: {
              type: 'pie',
              height: 350,
              toolbar: {
                  show: true,
                  tools: {
                      download: true,
                      selection: true,
                      zoom: true,
                      zoomin: true,
                      zoomout: true,
                      pan: true,
                      reset: true,
                  },
              },
          },
          series: @json($bugChartData['status']['series']),
          labels: @json($bugChartData['status']['labels']),
      };

      var chart = new ApexCharts(document.querySelector("#bugChart"), chartOptions);
      chart.render();

      document.querySelectorAll('.dropdown-item').forEach(function (item) {
          item.addEventListener('click', function (event) {
              event.preventDefault();
              var selectedType = this.getAttribute('data-chart-type');
              updateChart(selectedType);
              updateDropdownText(this.textContent);
          });
      });

      function updateChart(type) {
          var newOptions = {
              series: type === 'status' ? @json($bugChartData['status']['series']) : @json($bugChartData['severity']['series']),
              labels: type === 'status' ? @json($bugChartData['status']['labels']) : @json($bugChartData['severity']['labels']),
          };

          chart.updateOptions(newOptions);
      }

      function updateDropdownText(text) {
          var button = document.querySelector('#chartTypeDropdown');
          button.textContent = text;
      }

      // Initialize with default selection
      updateDropdownText('Bug Status');
  });
</script>
<div class="row gy-4">
  <!-- Project Progress Chart -->
  <div class="col-lg-12">
      <div class="card">
          <div class="card-header">
              <h5 class="mb-1">Project Progress</h5>
          </div>
          <div class="card-body">
              <div id="projectProgressChart" style="height: 350px;"></div>
              <script>
                  document.addEventListener('DOMContentLoaded', function () {
                      // Fake data for testing
                      var fakeProjectProgressData = @json($pros->pluck('progress'));
                      var fakeProjectNames = @json($pros->pluck('proj_name'));
                      // Define chart options
                      var projectProgressOptions = {
                          chart: {
                              type: 'bar',
                              height: 350,
                              stacked: true,
                              zoom: {
                                  enabled: false
                              }
                          },
                          series: [{
                              name: 'Progress',
                              data: fakeProjectProgressData
                          }],
                          xaxis: {
                              categories: fakeProjectNames,
                              labels: {
                                  rotate: -45
                              }
                          },
                          yaxis: {
                              title: {
                                  text: 'Progress (%)'
                              },
                              max: 100
                          },
                          plotOptions: {
                              bar: {
                                  horizontal: false,
                                  columnWidth: '55%'
                              }
                          },
                          fill: {
                              opacity: 1
                          },
                          legend: {
                              position: 'top'
                          }
                      };

                      // Initialize and render the chart
                      var projectProgressChart = new ApexCharts(document.querySelector("#projectProgressChart"), projectProgressOptions);
                      projectProgressChart.render();
                  });
              </script>
          </div>
      </div>
  </div>
</div>


  <!--/ Total Earning -->

{{--
  <!-- More on forums and users-->
  <div class="col-xl-4 col-md-6">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Forums by people</h5>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="saleStatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="mdi mdi-dots-vertical mdi-24px"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="saleStatus">
            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
          <div class="d-flex align-items-center">
            <div class="avatar me-3">
              <div class="avatar-initial bg-label-success rounded-circle">AS</div>
            </div>
            <div>
              <div class="d-flex align-items-center gap-1">
                <h6 class="mb-0">Amirul Shafiq Bin Amirrullah</h6>
              </div>
              <small>Coding is hard >_<</small>
            </div>
          </div>
          <div class="text-end">
            <h6 class="mb-0">3</h6>
            <small>likes</small>
          </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
          <div class="d-flex align-items-center">
            <div class="avatar me-3">
              <span class="avatar-initial bg-label-danger rounded-circle">AJ</span>
            </div>
            <div>
              <div class="d-flex align-items-center gap-1">
                <h6 class="mb-0">Aum Jeevan</h6>
              </div>
              <small>All right. My job's done!</small>
            </div>
          </div>
          <div class="text-end">
            <h6 class="mb-0">31</h6>
            <small>Likes</small>
          </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
          <div class="d-flex align-items-center">
            <div class="avatar me-3">
              <span class="avatar-initial bg-label-warning rounded-circle">RA</span>
            </div>
            <div>
              <div class="d-flex align-items-center gap-1">
                <h6 class="mb-0">Rick Astley</h6>
              </div>
              <small>Never gonna give you up</small>
            </div>
          </div>
          <div class="text-end">
            <h6 class="mb-0">8</h6>
            <small>likes</small>
          </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
          <div class="d-flex align-items-center">
            <div class="avatar me-3">
              <span class="avatar-initial bg-label-secondary rounded-circle">RR</span>
            </div>
            <div>
              <div class="d-flex align-items-center gap-1">
                <h6 class="mb-0">Roslina Rashid</h6>

              </div>
              <small>Have to delay some work. Sorry!</small>
            </div>
          </div>
          <div class="text-end">
            <h6 class="mb-0">0</h6>
            <small>likes</small>
          </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <div class="avatar me-3">
              <span class="avatar-initial bg-label-danger rounded-circle">MR</span>
            </div>
            <div>
              <div class="d-flex align-items-center gap-1">
                <h6 class="mb-0">Mohd. Rashid</h6>

              </div>
              <small>That's a wrap guys! Thank you very much for ...</small>
            </div>
          </div>
          <div class="text-end">
            <h6 class="mb-0">10</h6>
            <small>Likes</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Sales by Countries -->

  <!-- Deposit / Withdraw -->
  <div class="col-xl-8">
    <div class="card h-100">
      <div class="card-body row g-2">
        <div class="col-12 col-md-6 card-separator pe-0 pe-md-3">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Deposit</h5>
            <a class="fw-medium" href="javascript:void(0);" style="color: #3f58b0;">View all</a>
          </div>
          <div class="pt-2">
            <ul class="p-0 m-0">
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/payments/gumroad.png')}}" class="img-fluid" alt="gumroad" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Gumroad Account</h6>
                    <small>Sell UI Kit</small>
                  </div>
                  <h6 class="text-success mb-0">+$4,650</h6>
                </div>
              </li>
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/payments/mastercard-2.png')}}" class="img-fluid" alt="mastercard" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Mastercard</h6>
                    <small>Wallet deposit</small>
                  </div>
                  <h6 class="text-success mb-0">+$92,705</h6>
                </div>
              </li>
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/payments/stripes.png')}}" class="img-fluid" alt="stripes" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Stripe Account</h6>
                    <small>iOS Application</small>
                  </div>
                  <h6 class="text-success mb-0">+$957</h6>
                </div>
              </li>
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/payments/american-bank.png')}}" class="img-fluid" alt="american" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">American Bank</h6>
                    <small>Bank Transfer</small>
                  </div>
                  <h6 class="text-success mb-0">+$6,837</h6>
                </div>
              </li>
              <li class="d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/payments/citi.png')}}" class="img-fluid" alt="citi" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Bank Account</h6>
                    <small>Wallet deposit</small>
                  </div>
                  <h6 class="text-success mb-0">+$446</h6>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-12 col-md-6 ps-0 ps-md-3 mt-3 mt-md-2">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Withdraw</h5>
            <a class="fw-medium" href="javascript:void(0);" style="color: #3f58b0;">View all</a>
          </div>
          <div class="pt-2">
            <ul class="p-0 m-0">
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/brands/google.png')}}" class="img-fluid" alt="google" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Google Adsense</h6>
                    <small>Paypal deposit</small>
                  </div>
                  <h6 class="text-danger mb-0">-$145</h6>
                </div>
              </li>
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/brands/github.png')}}" class="img-fluid" alt="github" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Github Enterprise</h6>
                    <small>Security &amp; compliance</small>
                  </div>
                  <h6 class="text-danger mb-0">-$1870</h6>
                </div>
              </li>
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/brands/slack.png')}}" class="img-fluid" alt="slack" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Upgrade Slack Plan</h6>
                    <small>Debit card deposit</small>
                  </div>
                  <h6 class="text-danger mb-0">$450</h6>
                </div>
              </li>
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/payments/digital-ocean.png')}}" class="img-fluid" alt="digital" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Digital Ocean</h6>
                    <small>Cloud Hosting</small>
                  </div>
                  <h6 class="text-danger mb-0">-$540</h6>
                </div>
              </li>
              <li class="d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                  <img src="{{asset('assets/img/icons/brands/aws.png')}}" class="img-fluid" alt="aws" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">AWS Account</h6>
                    <small>Choosing a Cloud Platform</small>
                  </div>
                  <h6 class="text-danger mb-0">-$21</h6>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  --}}

  <!-- Deposit / Withdraw -->

  <!--/ Data Tables -->
</div>
@endsection
