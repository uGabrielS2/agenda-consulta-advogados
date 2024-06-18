    var modalDelete = document.getElementById('modalDelete');
    modalDelete.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; 
        var id = button.getAttribute('data-id'); 
        var confirmDeleteButton = document.getElementById('confirmDeleteButton');
        confirmDeleteButton.setAttribute('href', 'verify/deleteAgendamento.php?id=' + id);
    });
