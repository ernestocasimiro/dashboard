document.addEventListener('DOMContentLoaded', function () {
    fetch('api/get_classes.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('class-table-body');
                tbody.innerHTML = ''; // Limpa a tabela antes

                data.data.forEach(turma => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>${turma.id}</td>
                        <td>${turma.nome}</td>
                        <td>${turma.ano}</td>
                        <td>${turma.diretor_nome}</td>
                        <td>${turma.alunos_matriculados}</td>
                        <td>${turma.capacidade}</td>
                        <td>
                            <button class="edit-btn">Editar</button>
                            <button class="delete-btn">Eliminar</button>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });
            } else {
                console.error('Erro ao carregar turmas:', data.error || data.message);
            }
        })
        .catch(error => {
            console.error('Erro de conexão:', error);
        });
});
