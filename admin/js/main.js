import './class/load-teachers.js';
import './class/student-selector.js';
import './class/form-handler.js';


document.addEventListener('DOMContentLoaded', () => {
    carregarProfessores();
    inicializarSelecaoDeAlunos();
    inicializarFormulario();
});

fetch('api/get_teachers.php')
  .then(res => res.json())
  .then(teachers => {
    const select = document.querySelector('#diretor-turma-select'); // ajuste conforme o ID real
    teachers.forEach(teacher => {
      const option = document.createElement('option');
      option.value = teacher.id;
      option.textContent = teacher.name;
      select.appendChild(option);
    });
  });


  document.querySelector('#adicionar-alunos-btn').addEventListener('click', () => {
    fetch('api/get_students.php')
      .then(res => res.json())
      .then(students => {
        const container = document.querySelector('#available-students');
        container.innerHTML = '';
        students.forEach(student => {
          const div = document.createElement('div');
          div.className = 'student-card';
          div.innerHTML = `
            <input type="checkbox" value="${student.id}" />
            ${student.nome}
          `;
          container.appendChild(div);
        });
        document.querySelector('#students-modal').style.display = 'block';
      });
  });

  document.addEventListener("DOMContentLoaded", () => {
    fetch('../api/get_teachers.php')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('class-director');
            data.forEach(teacher => {
                const option = document.createElement('option');
                option.value = teacher.id;
                option.textContent = teacher.name;
                select.appendChild(option);
            });
        })
        .catch(err => console.error('Erro ao carregar professores:', err));
});

let selectedStudents = [];
document.getElementById('confirm-students').addEventListener('click', () => {
    const checkboxes = document.querySelectorAll('#available-students input[type="checkbox"]:checked');
    selectedStudents = Array.from(checkboxes).map(cb => parseInt(cb.value));

    const selectedContainer = document.getElementById('student-selection-container');
    selectedContainer.innerHTML = ''; // limpa seleção atual

    if (selectedStudents.length === 0) {
        selectedContainer.innerHTML = '<p class="empty-message">Nenhum aluno selecionado</p>';
    } else {
        selectedStudents.forEach(id => {
            const label = checkboxes.find(cb => cb.value == id)?.parentElement.textContent.trim();
            const div = document.createElement('div');
            div.className = 'selected-student';
            div.textContent = label;
            selectedContainer.appendChild(div);
        });
    }

    // Atualiza contador
    document.getElementById('selected-students-count').textContent = selectedStudents.length;

    // Fecha modal
    document.getElementById('students-modal').style.display = 'none';
});

document.getElementById('class-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const nome = document.getElementById('class-name').value;
    const ano = document.getElementById('class-grade').value;
    const capacidade = parseInt(document.getElementById('class-capacity').value);
    const diretor_id = parseInt(document.getElementById('class-director').value);
    const turno = document.getElementById('class-schedule').value;
    const descricao = document.getElementById('class-description').value;

    if (!nome || !ano || !capacidade || !diretor_id) {
        alert('Preencha todos os campos obrigatórios.');
        return;
    }

    if (selectedStudents.length > capacidade) {
        alert(`Você selecionou mais alunos (${selectedStudents.length}) do que a capacidade da turma (${capacidade}).`);
        return;
    }

    const payload = {
        nome,
        ano,
        capacidade,
        diretor_id,
        turno,
        descricao,
        alunos: selectedStudents
    };

    // Mostra spinner (caso esteja usando)
    document.querySelector('.loading-icon').style.display = 'inline-block';

    try {
        const response = await fetch('../api/create_class.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        if (result.success) {
            alert('Turma cadastrada com sucesso!');
            // Fechar modal, resetar form, etc...
        } else {
            alert(`Erro ao cadastrar: ${result.message}`);
        }
    } catch (err) {
        console.error(err);
        alert('Erro inesperado ao cadastrar turma.');
    } finally {
        document.querySelector('.loading-icon').style.display = 'none';
    }
});




// TUDO SOBRE TURMA


document.addEventListener('DOMContentLoaded', function () {
    // Carregar lista de turmas ao iniciar
    carregarTurmas();

    // Configurar o formulário de cadastro de turmas
    const classForm = document.getElementById('class-form');
    if (classForm) {
        classForm.addEventListener('submit', function (e) {
            e.preventDefault();
            salvarTurma(this);
        });
    }

    // Configurar o botão de pesquisa
    const classSearch = document.getElementById('class-search');
    if (classSearch) {
        classSearch.addEventListener('input', function () {
            filtrarTurmas();
        });
    }

    // Configurar o filtro de ano
    const gradeFilter = document.getElementById('grade-filter');
    if (gradeFilter) {
        gradeFilter.addEventListener('change', function () {
            filtrarTurmas();
        });
    }
});

// Função para carregar todas as turmas
function carregarTurmas() {
    fetch('api/classes.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderizarTurmas(data.data);
            } else {
                console.error('Erro ao carregar turmas:', data.message);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}

// Função para renderizar as turmas na tabela
function renderizarTurmas(turmas) {
    const tableBody = document.getElementById('class-table-body');
    
    if (!tableBody) return;
    
    tableBody.innerHTML = '';
    
    if (turmas.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Nenhuma turma encontrada</td></tr>';
        return;
    }
    
    turmas.forEach(turma => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${turma.id}</td>
            <td>${turma.nome}</td>
            <td>${turma.ano}º Ano</td>
            <td>${turma.diretor_nome || 'Não atribuído'}</td>
            <td>${turma.total_alunos}</td>
            <td>${turma.capacidade}</td>
            <td>
                <button class="action-btn view" onclick="verTurma(${turma.id})">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="action-btn edit" onclick="editarTurma(${turma.id})">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button class="action-btn delete" onclick="excluirTurma(${turma.id})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Função para filtrar turmas baseado na pesquisa e filtro de ano
function filtrarTurmas() {
    const searchTerm = document.getElementById('class-search').value.toLowerCase();
    const yearFilter = document.getElementById('grade-filter').value;
    
    const rows = document.querySelectorAll('#class-table-body tr');
    
    rows.forEach(row => {
        const nome = row.cells[1].textContent.toLowerCase();
        const ano = row.cells[2].textContent;
        
        let mostrarPorPesquisa = nome.includes(searchTerm);
        let mostrarPorAno = true;
        
        if (yearFilter) {
            mostrarPorAno = ano.includes(yearFilter + 'º');
        }
        
        row.style.display = (mostrarPorPesquisa && mostrarPorAno) ? '' : 'none';
    });
}

// Função para salvar uma nova turma
function salvarTurma(form) {
    // Mostra ícone de loading
    const saveBtn = form.querySelector('.save-btn');
    saveBtn.classList.add('loading');
    
    const formData = new FormData(form);
    
    // Adicionar alunos selecionados se houver
    const selectedStudents = getSelectedStudents();
    if (selectedStudents.length > 0) {
        formData.append('selectedStudents', JSON.stringify(selectedStudents));
    }
    
    fetch('api/classes.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        saveBtn.classList.remove('loading');
        
        if (data.success) {
            alert(data.message);
            document.getElementById('class-modal').style.display = 'none';
            form.reset();
            carregarTurmas(); // Recarregar a lista de turmas
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        saveBtn.classList.remove('loading');
        console.error('Erro ao salvar turma:', error);
        alert('Erro ao salvar turma. Verifique o console para mais detalhes.');
    });
}

// Função auxiliar para obter os alunos selecionados
function getSelectedStudents() {
    // Esta função pode ser implementada quando você adicionar a funcionalidade de seleção de alunos
    // Por enquanto, retorna um array vazio
    return [];
}

// Funções para manipulação de turmas (serão implementadas posteriormente)
function verTurma(id) {
    alert('Visualizar turma ' + id);
    // Implementar a visualização da turma
}

function editarTurma(id) {
    alert('Editar turma ' + id);
    // Implementar a edição da turma
}

function excluirTurma(id) {
    if (confirm('Tem certeza que deseja excluir esta turma?')) {
        // Implementar a exclusão da turma
        alert('Turma excluída');
    }
}
