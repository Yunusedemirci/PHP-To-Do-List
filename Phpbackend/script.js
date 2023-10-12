    const editButtons = document.querySelectorAll('.edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const listItem = button.parentElement.parentElement;
            const textElement = listItem.querySelector('.text');
            const editForm = listItem.querySelector('form[action="#"]');
            const editInput = editForm.querySelector('input[name="newTodoText"]');
            
            textElement.style.display = 'none';
            editInput.style.display = 'inline-block';
            editForm.querySelector('button[name="editTodo"]').style.display = 'inline-block';
            button.style.display = 'none';
        });
    });
