<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Turmas - Sistema de Gestão Escolar</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Estilos para o formulário melhorado */
.input-with-tag {
    position: relative;
    display: flex;
    align-items: center;
}

.input-with-tag input {
    padding-right: 50px;
}

.input-with-tag .input-tag {
    position: absolute;
    right: 10px;
    color: #666;
    font-size: 0.9rem;
}

.student-selection {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
}

.student-list-container {
    max-height: 150px;
    overflow-y: auto;
    margin-bottom: 10px;
    padding: 5px;
    background: #f9f9f9;
    border-radius: 3px;
}

.student-counter {
    text-align: right;
    font-size: 0.9rem;
    color: #666;
}

.empty-message {
    color: #999;
    font-style: italic;
    text-align: center;
    padding: 10px;
}

.add-student-btn {
    background-color: #f0f0f0;
    border: 1px dashed #ccc;
    width: 100%;
    padding: 8px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.add-student-btn:hover {
    background-color: #e0e0e0;
}

/* Modal de alunos */
.student-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
    max-height: 300px;
    overflow-y: auto;
    margin: 15px 0;
}

.student-item {
    display: flex;
    align-items: center;
    padding: 8px;
    border: 1px solid #eee;
    border-radius: 4px;
    cursor: pointer;
}

.student-item:hover {
    background-color: #f5f5f5;
}

.student-item.selected {
    background-color: #e6f7ff;
    border-color: #91d5ff;
}

.loading-icon {
    display: none;
    margin-left: 8px;
}

.form-actions .save-btn.loading .loading-icon {
    display: inline-block;
}

.form-actions .save-btn.loading .button-text {
    display: none;
}
    /* Estilos adicionais para garantir que o modal funcione corretamente */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 800px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .close-modal, .close-view-modal {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    
    .close-modal:hover, .close-view-modal:hover {
      color: #000;
    }
    
    .form-actions {
      margin-top: 20px;
      text-align: right;
    }
    
    .cancel-btn, .close-view-btn {
      background-color: #f44336;
      color: white;
      border: none;
      padding: 10px 15px;
      margin-right: 10px;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .save-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .cancel-btn:hover, .save-btn:hover, .close-view-btn:hover {
      opacity: 0.8;
    }

    .user-dropdown {
      position: relative;
      cursor: pointer;
    }
    
    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 100%;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 4px;
      padding: 8px 0;
      z-index: 1000;
      min-width: 150px;
    }
    
    .dropdown-menu.show {
      display: block;
    }
    
    .dropdown-item {
      padding: 8px 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #333;
      text-decoration: none;
    }
    
    .dropdown-item:hover {
      background-color: #f5f5f5;
    }
  </style>
  <!-- Adicionar um script inline para garantir que o botão funcione -->
  <script>
    // Script de inicialização rápida para garantir que o botão funcione imediatamente
    document.addEventListener('DOMContentLoaded', function() {
      console.log("Inicializando botão 'Adicionar Turma'...");
      const addClassBtn = document.getElementById('add-class-btn');
      const classModal = document.getElementById('class-modal');
      
      if (addClassBtn && classModal) {
        addClassBtn.addEventListener('click', function() {
          console.log("Botão 'Adicionar Turma' clicado!");
          classModal.style.display = 'block';
        });
        
        // Adicionar listeners para fechar o modal
        const closeModal = document.querySelector('.close-modal');
        const cancelBtn = document.querySelector('.cancel-btn');
        
        if (closeModal) {
          closeModal.addEventListener('click', function() {
            classModal.style.display = 'none';
          });
        }
        
        if (cancelBtn) {
          cancelBtn.addEventListener('click', function() {
            classModal.style.display = 'none';
          });
        }
        
        // Fechar modal ao clicar fora dele
        window.addEventListener('click', function(e) {
          if (e.target === classModal) {
            classModal.style.display = 'none';
          }
        });
      } else {
        console.error("Botão 'Adicionar Turma' ou modal não encontrado!");
      }
    });
  </script>
  
  <script src="js/script.js"></script>
</head>
<body>
<div class="container">
      <nav class="sidebar">
          <div class="logo">
              <h2>Pitruca Camama</h2>
          </div>
          <ul class="nav-links">
              <!-- Painel (Visão Geral) -->
              <li data-tab="dashboard">
                  <a href="index.php">
                      <i class="fas fa-tachometer-alt"></i> 
                      <span>Painel</span>
                  </a>
              </li>
              
              <!-- Gestão De Alunos -->
              <li class="has-submenu" data-tab="student-management">
                  <div class="menu-item">
                      <i class="fas fa-user-graduate"></i> 
                      <span>Gestão De Alunos</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="register-students">
                          <a href="students.php">
                              <i class="fas fa-user-plus"></i> 
                              <span>Estudantes</span>
                          </a>
                      </li>
                      <li data-tab="attendance">
                          <a href="attendance.php">
                              <i class="fas fa-calendar-check"></i> 
                              <span>Presença</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Gestão Pedagógica -->
              <li class="has-submenu" data-tab="pedagogical-management">
                  <div class="menu-item" class="has-submenu active" >
                      <i class="fas fa-chalkboard"></i> 
                      <span>Gestão Pedagógica</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li class="active" data-tab="classes">
                          <a href="classes.php">
                              <i class="fas fa-users"></i> 
                              <span>Turmas</span>
                          </a>
                      </li>
                      <li data-tab="schedule">
                          <a href="schedule.php">
                              <i class="fas fa-calendar-alt"></i> 
                              <span>Horários</span>
                          </a>
                      </li>
                      <li data-tab="tests">
                          <a href="tests.php">
                              <i class="fas fa-file-alt"></i> 
                              <span>Provas</span>
                          </a>
                      </li>
                      <li data-tab="bulletins">
                          <a href="bulletins.php">
                              <i class="fas fa-file-invoice"></i> 
                              <span>Boletins</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Gestão de Funcionários -->
              <li class="has-submenu" data-tab="staff-management">
                  <div class="menu-item">
                      <i class="fas fa-chalkboard-teacher"></i> 
                      <span>Gestão de Funcionários</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="register-teacher">
                          <a href="teacher.php">
                              <i class="fas fa-user-plus"></i> 
                              <span>Professores/Coordenadores</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Utilizadores -->
              <li class="has-submenu" data-tab="users">
                  <div class="menu-item">
                      <i class="fas fa-users"></i> 
                      <span>Utilizadores</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="guardians">
                          <a href="guardians.php">
                              <i class="fas fa-user-friends"></i> 
                              <span>Encarregados</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Comunicação -->
              <li class="has-submenu" data-tab="communication">
                  <div class="menu-item">
                      <i class="fas fa-comments"></i> 
                      <span>Comunicação</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="messages">
                          <a href="messages.php">
                              <i class="fas fa-envelope"></i> 
                              <span>Mensagens</span>
                          </a>
                      </li>
                      <li data-tab="notice-board">
                          <a href="notices.php">
                              <i class="fas fa-bullhorn"></i> 
                              <span>Quadro de Avisos</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Finanças -->
              <li class="has-submenu" data-tab="finances">
                  <div class="menu-item">
                      <i class="fas fa-money-bill-wave"></i> 
                      <span>Finanças</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="financial-management">
                          <a href="finances.php">
                              <i class="fas fa-chart-line"></i> 
                              <span>Gestão Financeira</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Configurações -->
              <li data-tab="settings">
                  <a href="settings.php">
                      <i class="fas fa-cog"></i> 
                      <span>Configurações</span>
                  </a>
              </li>
          </ul>
          <!-- Removed the logout div from here -->
      </nav>
      
      <main class="content">
          <header>
              <div class="search-bar">
                  <i class="fas fa-search"></i>
                  <input type="text" placeholder="Pesquisar...">
              </div>
              <div class="user-info">
                  <div class="user user-dropdown">
                        <img src="login\images\semft-removebg-preview.png" alt="" class="userOptions__avatar img-circle" width="42" height="42">
                        <span><?php echo $_SESSION['fname']; ?></span>

                        <div class="dropdown-menu">
                        <a href="/dashboardpitruca_copia/login/logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>

                        </div>
                  </div>
              </div>
          </header>
          
          <div class="tab-content">
    <!-- Gestão Pedagógica - Turmas -->
<div class="tab-pane active" id="classes">
    <div class="section-header">
        <h2>Turmas</h2>
        <button class="add-btn" id="add-class-btn">
            <i class="fas fa-plus"></i> Adicionar Turma
        </button>
    </div>

    <!-- Filtros simplificados (removido o seletor de turma) -->
    <div class="filter-controls">
        <div class="search-filter">
            <input type="text" id="class-search" placeholder="Pesquisar turmas...">
        </div>
        <div class="dropdown-filter">
            <select id="grade-filter">
                <option value="">Todos os Anos</option>
                <option value="10">10º Ano</option>
                <option value="11">11º Ano</option>
                <option value="12">12º Ano</option>
                <option value="13">13º Ano</option>
            </select>
        </div>
    </div>

    <!-- Tabela de turmas -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Turma</th>
                    <th>Ano</th>
                    <th>Diretor de Turma</th>
                    <th>Nº de Alunos</th>
                    <th>Capacidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="class-table-body">
                <!-- Linhas dinâmicas serão carregadas via JS -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para adicionar/editar turmas -->
<div class="modal" id="class-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="class-modal-title">Adicionar Nova Turma</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="class-form" method="POST" action="api/classes.php">
                <div class="form-group">
                    <label for="class-name">Nome da Turma*</label>
                    <input type="text" id="class-name" name="classname" required 
                        pattern="[A-Za-z0-9\u00C0-\u00FF ]+" 
                        title="Apenas letras, números e espaços"
                        placeholder="Ex: Turma 10ª A Informática">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="class-grade">Ano*</label>
                        <select id="class-grade" name="classyear" required>
                            <option value="">Selecionar Ano</option>
                            <option value="10">10º Ano</option>
                            <option value="11">11º Ano</option>
                            <option value="12">12º Ano</option>
                            <option value="13">13º Ano</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class-capacity">Capacidade*</label>
                        <div class="input-with-tag">
                            <input type="number" id="class-capacity" name="classcapacity" min="1" max="25" value="25" required>
                            <span class="input-tag">alunos</span>
                        </div>
                        <small>Máximo: 25 alunos</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="class-director">Diretor de Turma*</label>
                        <select id="class-director" name="classdirector" required>
                            <option value="">Carregando professores...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class-schedule">Turno</label>
                        <select id="class-schedule" name="classschedule">
                            <option value="manha">Manhã</option>
                            <option value="tarde">Tarde</option>
                            <option value="noite">Noite</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="class-students">Alunos</label>
                    <div class="student-selection">
                        <div class="student-list-container" id="student-selection-container">
                            <p class="empty-message">Nenhum aluno selecionado</p>
                            <input type="hidden" name="student_ids[]" id="selected-student-ids">
                        </div>
                        <button type="button" class="add-student-btn" id="add-students-btn">
                            <i class="fas fa-plus"></i> Adicionar Alunos
                        </button>
                    </div>
                    <div class="student-counter">
                        <span id="selected-students-count">0</span>/<span id="max-students">25</span> alunos selecionados
                    </div>
                </div>

                <div class="form-group">
                    <label for="class-description">Descrição</label>
                    <textarea id="class-description" name="classdescription" rows="3" placeholder="Informações adicionais sobre a turma"></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="cancel-btn">Cancelar</button>
                    <button type="submit" class="save-btn">
                        <span class="button-text">Salvar Turma</span>
                        <i class="fas fa-spinner fa-spin loading-icon"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para seleção de alunos -->
<div class="modal" id="students-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Selecionar Alunos</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <div class="search-filter">
                <input type="text" id="student-search" placeholder="Pesquisar alunos...">
            </div>
            <div class="student-grid" id="available-students">
                <!-- Lista de alunos disponíveis -->
            </div>
            <div class="modal-actions">
                <button type="button" class="cancel-btn">Cancelar</button>
                <button type="button" class="confirm-btn" id="confirm-students">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<script>
// Popula o select de professores via AJAX
document.addEventListener('DOMContentLoaded', function () {
    const directorSelect = document.getElementById('class-director');

    // Verificar se o elemento existe antes de tentar carregar os dados
    if (!directorSelect) {
        console.error('Elemento select para diretores não encontrado');
        return;
    }

    // Mostrar mensagem de carregamento
    directorSelect.innerHTML = '<option value="">Carregando professores...</option>';
    
    // Fazer a requisição para a API
    fetch('api/teacher.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta da rede: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            // Limpar o select e adicionar a opção padrão
            directorSelect.innerHTML = '<option value="">Selecionar Professor</option>';
            
            // Verificar se há dados e se é um array
            if (Array.isArray(data) && data.length > 0) {
                // Adicionar cada professor como uma opção
                data.forEach(teacher => {
                    const option = document.createElement('option');
                    option.value = teacher.id;
                    // Usar o nome completo do professor (concatenando fname e lname se disponíveis)
                    if (teacher.fname && teacher.lname) {
                        option.textContent = `${teacher.fname} ${teacher.lname}`;
                    } else if (teacher.name) {
                        option.textContent = teacher.name;
                    } else {
                        option.textContent = `Professor ID: ${teacher.id}`;
                    }
                    directorSelect.appendChild(option);
                });
            } else {
                // Se não houver professores, mostrar mensagem
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "Nenhum professor cadastrado";
                directorSelect.appendChild(option);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar professores:', error);
            // Exibir mensagem de erro no select
            directorSelect.innerHTML = '<option value="">Erro ao carregar professores</option>';
        });
});

// Carregar alunos disponíveis via AJAX
document.addEventListener('DOMContentLoaded', function() {
    fetch('api/get_students.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const studentContainer = document.getElementById('available-students');
                data.data.forEach(student => {
                    const studentDiv = document.createElement('div');
                    studentDiv.classList.add('student-item');
                    studentDiv.textContent = `${student.fname} ${student.lname}`;
                    studentDiv.dataset.id = student.id;
                    studentDiv.addEventListener('click', function() {
                        const selectedStudentIds = document.getElementById('selected-student-ids');
                        const selectedStudentsCount = document.getElementById('selected-students-count');
                        let selectedStudents = Array.from(selectedStudentIds.value.split(','));

                        if (selectedStudents.includes(student.id.toString())) {
                            selectedStudents = selectedStudents.filter(id => id !== student.id.toString());
                        } else {
                            selectedStudents.push(student.id);
                        }

                        selectedStudentIds.value = selectedStudents.join(',');
                        selectedStudentsCount.textContent = selectedStudents.length;
                    });
                    studentContainer.appendChild(studentDiv);
                });
            }
        })
        .catch(error => {
            console.error('Erro ao carregar alunos:', error);
        });
});

// Envio de dados para criar a turma
document.getElementById('save-class').addEventListener('click', function() {
    const nome = document.getElementById('class-name').value;
    const ano = document.getElementById('class-year').value;
    const capacidade = document.getElementById('class-capacity').value;
    const diretor_id = document.getElementById('class-director').value; // O valor do diretor selecionado
    const turno = document.getElementById('class-shift').value;
    const descricao = document.getElementById('class-description').value;
    const alunos = document.getElementById('selected-student-ids').value.split(','); // Alunos selecionados

    // Exibindo os dados no console para depuração
    console.log({
        nome: nome,
        ano: ano,
        capacidade: capacidade,
        diretor_id: diretor_id,
        turno: turno,
        descricao: descricao,
        alunos: alunos
    });

    // Validando se os campos obrigatórios estão preenchidos
    if (!nome || !ano || !diretor_id || !turno) {
        alert('Preencha todos os campos obrigatórios.');
        return;
    }

    const data = {
        nome: nome,
        ano: ano,
        capacidade: capacidade,
        diretor_id: diretor_id,
        turno: turno,
        descricao: descricao,
        alunos: alunos
    };

    // Enviar os dados via fetch
    fetch('api/classes.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Turma criada com sucesso!');
        } else {
            alert('Erro ao criar turma: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao enviar dados para a API:', error);
        alert('Erro ao salvar a turma.');
    });
});
</script>




  <script src="js/script.js"></script>
  <script src="js/classes.js"></script>
  <script type="module" src="js/main.js"></script>
 

  

</body>
</html>
<?php }else{
    header("Location: ../login.php");
    exit;
} ?>
