export default {
    getInitData: function () {
        return fetch('api/initData')
            .then((response) => {
                return response.json();
            })
            .then((initData) => {
                return initData;
            });
    },
    addCompletedTask: function (task) {
        return fetch('api/saveCompletedTask', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'title': task['title'],
                'description': task['description'],
                '_token': document.head.querySelector('meta[name="csrf-token"]').content,
            }),
        })
        .then((response) => {
            return response.json();
        })
        .then((response) => {
            if (response.error) {
                throw new Error(response.error);
            }
            return response['idTask'];
        });
    },
    removeCompletedTask: function (idTask) {
        return fetch('api/task/' + idTask, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                '_token': document.head.querySelector('meta[name="csrf-token"]').content,
            }),
        })
        .then((response) => {
            return response.json();
        })
        .then((response) => {
            if (response.error) {
                throw new Error(response.error);
            }
        });
    },
    updateCompletedTask: function (task) {
        return fetch('api/task/' + task['backendId'], {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'title': task['title'],
                'description': task['description'],
                '_token': document.head.querySelector('meta[name="csrf-token"]').content,
            }),
        })
        .then((response) => {
            return response.json();
        })
        .then((response) => {
            if (response.error) {
                throw new Error(response.error);
            }
        });
    },
}
