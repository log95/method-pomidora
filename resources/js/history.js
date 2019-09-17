import backend from "./app/api/backend";

window.removeTask = function (idTask) {
    backend.removeCompletedTask(idTask)
        .catch((e) => {
            console.log(e);
            alert('Error occured.');
        });

    $('[data-task-id="' + idTask + '"]').remove();
};
