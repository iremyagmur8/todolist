// public/js/api.js

const apiUrl = '/';

const headers = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'Content-Type': 'application/json'
};

async function patchTodoStatus(todoId, completed) {
    try {
        const response = await fetch(`${apiUrl}${todoId}`, {
            method: 'PATCH',
            headers: headers,
            body: JSON.stringify({ completed })
        });
        if (!response.ok) {
            throw new Error('Failed update');
        }
        return response.json();
    } catch (error) {
        console.error('Error->:', error);
    }
}

async function deleteTodo(todoId) {
    try {
        const response = await fetch(`${apiUrl}${todoId}`, {
            method: 'DELETE',
            headers: headers
        });
        if (!response.ok) {
            throw new Error('Failed delete');
        }
        return response.json();
    } catch (error) {
        console.error('Error->', error);
    }
}

export { patchTodoStatus, deleteTodo };
