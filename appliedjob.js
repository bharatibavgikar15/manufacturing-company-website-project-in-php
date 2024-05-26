function editJob(id, currentStatus) {
    let newStatus = prompt("Enter new status (Accepted/Pending)", currentStatus);
    if (newStatus !== null && newStatus !== "" && (newStatus === 'Accepted' || newStatus === 'Pending')) {
        $.ajax({
            url: "appliedjob.php",
            type: "POST",
            data: {
                action: 'edit',
                id: id,
                newStatus: newStatus
            },
            success: function(response) {
                alert(response);
                location.reload(); // Reload the page to see the updated data
            },
            error: function(error) {
                alert("Error updating record");
            }
        });
    }
}

function deleteJob(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        $.ajax({
            url: "appliedjob.php",
            type: "POST",
            data: {
                action: 'delete',
                id: id
            },
            success: function(response) {
                alert(response);
                location.reload(); // Reload the page to see the updated data
            },
            error: function(error) {
                alert("Error deleting record");
            }
        });
    }
}
