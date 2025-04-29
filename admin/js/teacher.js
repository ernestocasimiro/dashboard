document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("teacher-modal");
    const openModalButton = document.getElementById("add-teacher-button"); // Botão para abrir o modal
    const closeModalButton = document.querySelector(".close-modal"); // Fechar o modal
    const cancelButton = document.getElementById("cancel-teacher-btn"); // Botão de cancelar no modal

    // Abrir o modal
    openModalButton.addEventListener("click", function() {
        modal.style.display = "block";
    });

    // Fechar o modal
    closeModalButton.addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Fechar o modal ao clicar em cancelar
    cancelButton.addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Fechar o modal ao clicar fora do conteúdo do modal
    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Submeter o formulário de cadastro
    const teacherForm = document.getElementById("teacher-form");
    teacherForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Evita o envio tradicional do formulário

        const formData = new FormData(teacherForm);

        fetch("process_add_teacher.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Professor adicionado com sucesso!");
                modal.style.display = "none"; // Fechar o modal
                // Recarregar a lista de professores
                loadTeachers();
            } else {
                alert("Erro ao adicionar o professor: " + data.error);
            }
        })
        .catch(error => {
            console.error("Erro ao enviar os dados:", error);
            alert("Ocorreu um erro ao adicionar o professor.");
        });
    });

    // Função para carregar a lista de professores
    function loadTeachers() {
        fetch("listar_professores.php")
            .then(response => response.json())
            .then(data => {
                const teachersTable = document.getElementById("teachers-table"); // Tabela onde a lista será exibida
                teachersTable.innerHTML = ''; // Limpa a tabela antes de adicionar novos dados
                data.teachers.forEach(teacher => {
                    const row = document.createElement("tr");
                    row.innerHTML = `<td>${teacher.name}</td>
                                     <td>${teacher.email}</td>
                                     <td>${teacher.subjects.join(', ')}</td>
                                     <td><a href="editar_professor.php?id=${teacher.id}">Editar</a></td>`;
                    teachersTable.appendChild(row);
                });
            });
    }
});
