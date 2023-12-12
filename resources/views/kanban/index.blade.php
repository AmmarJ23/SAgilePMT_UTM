<!--kanban Page-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kanban Board for {{ $sprint->sprint_name }}</title>

    <link rel="stylesheet" href="{{ asset('styles.css') }}" />

</head>

<body>
    <div class="board">
        <button id="add-lane-btn">Add New Lane</button>

        <div class="lanes">
            @foreach ($statuses as $status)
            <?php
            $taskList = $tasksByStatus[$status->id] ?? [];
            ?>
            <div class="swim-lane" data-status-id="{{ $status->id }}">
                <h3 class="heading">{{ $status->title }}</h3>


                <button type="button" class="rename-btn">Rename</button>


                <button type="button" class="delete-btn">Delete</button>


                <form class="form">
                    <input type="text" placeholder="New Task..." class="new-input" />
                    <button type="submit" class="new-submit-btn">Add +</button>
                </form>

                @foreach ($taskList as $task)
                <p class="task" draggable="true" data-task-id="{{ $task->id }}">{{ $task->title }}</p>
                @endforeach
            </div>
            @endforeach

            <!-- Add this inline style to your button in your HTML -->
            <button id="save-btn" style="padding: 10px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">Save</button>

        </div>
    </div>

    <script>
        //Function to handle common logic for creating a new task element
        function createTaskElement(value) {
            const newTask = document.createElement("p");
            newTask.classList.add("task");
            newTask.setAttribute("draggable", "true");
            newTask.innerText = value;

            newTask.addEventListener("dragstart", () => {
                newTask.classList.add("is-dragging");
            });

            newTask.addEventListener("dragend", () => {
                newTask.classList.remove("is-dragging");
            });

            return newTask;
        }


        // Function to handle common logic for handling drag and drop events
        function handleDragDropEvents(sourceLane, targetLane) {
            sourceLane.addEventListener("dragover", (e) => {
                e.preventDefault();
                const draggingTask = document.querySelector(".is-dragging");

                if (draggingTask) {
                    sourceLane.classList.add("drag-over");
                }
            });

            sourceLane.addEventListener("dragleave", () => {
                sourceLane.classList.remove("drag-over");
            });

            sourceLane.addEventListener("drop", (e) => {
                e.preventDefault();
                sourceLane.classList.remove("drag-over");

                const draggingTask = document.querySelector(".is-dragging");

                if (draggingTask) {
                    targetLane.appendChild(draggingTask);
                    draggingTask.classList.remove("is-dragging");
                }
            });
        }

        // Function to change the lane name
        function changeLaneName(lane, newName) {
            const heading = lane.querySelector(".heading");
            heading.innerText = newName;

            // Get the status ID associated with the lane
            const statusId = lane.dataset.statusId;

            // Make an AJAX request to update the lane name in the database
            fetch('{{ route("kanban.updateStatus") }}', {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        statusId: statusId,
                        newName: newName,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    // Handle the response from the controller method
                    console.log('After AJAX request to update lane name');
                    console.log(data);
                    alert(data.message); // Display a message received from the server
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        document.addEventListener("DOMContentLoaded", () => {
            const addLaneBtn = document.getElementById("add-lane-btn");



            const renameBtns = document.querySelectorAll(".rename-btn");
            const deleteBtns = document.querySelectorAll(".delete-btn");

            renameBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    const newName = prompt("Enter new name for the lane:");

                    if (newName !== null) {
                        const lane = btn.closest(".swim-lane");
                        changeLaneName(lane, newName);
                    }
                });
            });

            deleteBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    const lane = btn.closest(".swim-lane");
                    const laneId = lane.dataset.statusId;

                    // Make an AJAX request to delete the lane and update task statuses
                    fetch('{{ route("kanban.deleteStatus") }}', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                laneId: laneId,
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('After AJAX request to delete lane');
                            console.log(data);

                            // Check if the deletion was successful before removing the lane from the UI
                            if (data.success) {
                                lane.remove();
                                alert(data.message); // Display a message received from the server
                            } else {
                                alert(data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });


            const newSubmitBtns = document.querySelectorAll(".new-submit-btn");

            newSubmitBtns.forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    e.preventDefault();
                    const lane = btn.closest(".swim-lane");
                    const newInput = lane.querySelector(".new-input");
                    const value = newInput.value;

                    if (value.trim() !== "") {
                        const newTask = createTaskElement(value);
                        lane.appendChild(newTask);
                        newInput.value = "";
                    }
                });
            });

            const saveBtn = document.getElementById("save-btn");

            saveBtn.addEventListener("click", () => {
                console.log("Save button clicked");

                // Iterate through all lanes and tasks to gather their positions
                const positions = [];

                document.querySelectorAll(".swim-lane").forEach((lane, laneIndex) => {
                    const laneId = lane.dataset.statusId;

                    lane.querySelectorAll(".task").forEach((task, taskIndex) => {
                        const taskId = task.dataset.taskId;

                        positions.push({
                            taskId: taskId,
                            statusId: laneId,
                            position: taskIndex + 1, // Add 1 to make positions 1-based
                        });
                    });
                });

                console.log("Task positions to save:", positions);

                // Make an AJAX request to save the task positions in the database
                fetch('{{ route("kanban.updateTaskStatus") }}', {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            positions: positions,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle the response from the controller method
                        console.log('After AJAX request to save task positions');
                        console.log(data);
                        alert(data.message); // Display a message received from the server
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            // Function to create a new lane
            function createNewLane(laneName) {
                const newLane = document.createElement("div");
                newLane.classList.add("swim-lane");

                const newHeading = document.createElement("h3");
                newHeading.classList.add("heading");
                newHeading.innerText = laneName;

                const renameForm = document.createElement("form");
                const renameBtn = document.createElement("button");
                renameBtn.setAttribute("type", "button");
                renameBtn.innerText = "Rename";
                renameForm.appendChild(renameBtn);

                const deleteForm = document.createElement("form");
                const deleteBtn = document.createElement("button");
                deleteBtn.setAttribute("type", "button");
                deleteBtn.innerText = "Delete";
                deleteForm.appendChild(deleteBtn);

                const newForm = document.createElement("form");
                const newInput = document.createElement("input");
                newInput.setAttribute("type", "text");
                newInput.setAttribute("placeholder", "New Task...");
                const newSubmitBtn = document.createElement("button");
                newSubmitBtn.setAttribute("type", "submit");
                newSubmitBtn.innerText = "Add +";

                newForm.appendChild(newInput);
                newForm.appendChild(newSubmitBtn);

                newLane.appendChild(newHeading);
                newLane.appendChild(renameBtn);
                newLane.appendChild(deleteBtn);
                newLane.appendChild(newForm);

                document.querySelector(".lanes").appendChild(newLane);

                // Add event listener for submitting new tasks in the new lane
                newForm.addEventListener("submit", (e) => {
                    e.preventDefault();
                    const value = newInput.value;

                    if (!value) return;

                    const newTask = createTaskElement(value);

                    newLane.appendChild(newTask);

                    newInput.value = "";
                });

                // Add event listener for renaming the lane
                renameBtn.addEventListener("click", () => {
                    const newName = prompt("Enter new name for the lane:");

                    if (newName !== null) {
                        changeLaneName(newLane, newName);
                    }
                });

                // Add event listener for deleting the lane
                deleteBtn.addEventListener("click", () => {
                    newLane.remove();
                });

                // Call the function to handle drag and drop events for the new lane
                handleDragDropEvents(newLane, newLane);
            }

            // Add event listener for adding a new lane
            addLaneBtn.addEventListener("click", () => {
                const newLaneName = prompt("Enter the name for the new lane:");
                if (newLaneName !== null) {
                    createNewLane(newLaneName);

                    var projectID = "{{ $project->id }}"
                    var sprintID = "{{ $sprint->sprint_ID }}";

                    var dataToSend = {
                        statusName: newLaneName,
                        sprintID: sprintID,
                        project_id: projectID
                    };

                    // Make an AJAX request to call the controller method
                    fetch('{{ route("kanban.createStatus") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(dataToSend),
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Handle the response from the controller method
                            console.log('After AJAX request');
                            console.log(data);
                            alert(data.message); // Display a message received from the server
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });

                }
            });

            // Call the function to handle drag and drop events for existing lanes
            handleDragDropEvents(todoLane, todoLane);
            handleDragDropEvents(doingLane, doingLane);
            handleDragDropEvents(doneLane, doneLane);
        });

        //////////////////////////////////////////////////////////////////////

        const draggables = document.querySelectorAll(".task");
        const droppables = document.querySelectorAll(".swim-lane");

        draggables.forEach((task) => {
            task.addEventListener("dragstart", () => {
                task.classList.add("is-dragging");
            });
            task.addEventListener("dragend", () => {
                task.classList.remove("is-dragging");
            });
        });

        droppables.forEach((zone) => {
            zone.addEventListener("dragover", (e) => {
                e.preventDefault();

                const bottomTask = insertAboveTask(zone, e.clientY);
                const curTask = document.querySelector(".is-dragging");

                if (!bottomTask) {
                    zone.appendChild(curTask);
                } else {
                    zone.insertBefore(curTask, bottomTask);
                }
            });
        });

        const insertAboveTask = (zone, mouseY) => {
            const els = zone.querySelectorAll(".task:not(.is-dragging)");

            let closestTask = null;
            let closestOffset = Number.NEGATIVE_INFINITY;

            els.forEach((task) => {
                const {
                    top
                } = task.getBoundingClientRect();

                const offset = mouseY - top;

                if (offset < 0 && offset > closestOffset) {
                    closestOffset = offset;
                    closestTask = task;
                }
            });

            return closestTask;
        };
    </script>
</body>

</html>