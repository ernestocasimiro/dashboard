<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenador - Sistema de Gestão Escolar</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/teacher.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
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
              <li class="active" data-tab="dashboard">
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
                      <li data-tab="classes">
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
                              <span>Professores</span>
                          </a>
                          <a href="coordinator.php">
                              <i class="fas fa-user-plus"></i> 
                              <span>Coordenador</span>
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
                <!-- Gestão de Funcionários - Cadastrar Coordenadores -->
                <div class="tab-pane active" id="register-coordinators">
                    <div class="section-header">
                        <h2>Cadastrar Coordenador</h2>
                        <button class="add-btn" id="add-coordinator-btn">
                            <i class="fas fa-plus"></i> Adicionar Coordenador
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Educando</th>
                                    <th>Contato</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="coordinator-table-body">
                                <!-- coordinator data will be populated here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination">
                        <button class="pagination-btn" disabled><i class="fas fa-chevron-left"></i></button>
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <button class="pagination-btn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </main>
    </div>
<!-- Modal para adicionar/editar Coordenadores -->
<div class="modal" id="coordinator-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="coordinator-modal-title">Adicionar Novo Coordenador</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="coordinator-form">
                <input type="hidden" id="coordinator-id">
                
                <!-- Informações Pessoais -->
                <fieldset>
                    <legend>Informações Pessoais</legend>
                    <div class="form-group">
                        <label for="fname">Primeiro Nome <span class="required">*</span></label>
                        <input type="text" id="fname" placeholder="Primeiro nome do Coordenador" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Último Nome <span class="required">*</span></label>
                        <input type="text" id="lname" placeholder="Último nome do Coordenador" required>
                    </div>
                  
                    <div class="form-row">
                        <div class="form-group">
                            <label for="coordinator-gender">Gênero <span class="required">*</span></label>
                            <select id="coordinator-gender" required>
                                <option value="">Selecionar Gênero</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="coordinator-dob">Data de Nascimento</label>
                            <input type="date" id="coordinator-dob" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bi-number">Número do Bilhete de Identidade (BI)</label>
                        <input type="text" id="bi-number" placeholder="Ex: 0000000LA000" required pattern="^\d{7}[A-Za-z]{2}\d{3}$" title="O BI deve seguir o formato: 0000000LA000">
                    </div>
                    
                    <div class="form-group">
                        <label for="coordinator-address">Endereço</label>
                        <textarea id="coordinator-address" rows="2" placeholder="Endereço completo"></textarea>
                    </div>

                    <!-- NOVO Campo: Área de Atuação -->
                    <div class="form-group">
                        <label for="coordinator-area">Área de Atuação <span class="required">*</span></label>
                        <select id="coordinator-area" name="area" required>
                        <option value="">Selecionar Área</option>
                        <option value="Informática">Coordenador do curso de Informática</option>
                        <option value="CEJ">Coordenador do CEJ</option>
                        <option value="CFB">Coordenador do CFB</option>
                        <option value="Electromecânica">Coordenador do curso de Electromecânica</option>
                        <option value="Turno Manhã">Coordenador do Turno da Manhã</option>
                        <option value="Turno Tarde">Coordenador do Turno da Tarde</option>
                    </select>
                        <small class="area-requirements">Selecione a área de atuação do coordenador.</small>

                    </div>
                    <!-- FIM do novo campo -->
                </fieldset>

                <!-- Informações de Contato -->
                <fieldset>
                    <legend>Informações de Contato</legend>
                    <div class="form-group">
                        <label for="coordinator-contact">Número de Contato <span class="required">*</span></label>
                        <div class="phone-input-container">
                            <select id="country-code" class="country-code">
                                <option value="+244">+244 (Angola)</option>
                                <option value="+351">+351 (Portugal)</option>
                                <!-- Outros códigos... -->
                            </select>
                            <input type="tel" id="coordinator-contact" placeholder="XXX XXX XXX" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="coordinator-email">Email</label>
                        <input type="email" id="coordinator-email" placeholder="exemplo@email.com">
                    </div>
                </fieldset>

                <!-- Informações de Acesso -->
                <fieldset>
                    <legend>Informações de Acesso</legend>
                    <div class="form-group">
                        <label for="coordinator-username">Nome de Usuário <span class="required">*</span></label>
                        <input type="text" id="coordinator-username" placeholder="Nome de usuário" required>
                    </div>
                    <div class="form-group">
                        <label for="coordinator-password">Palavra-passe <span class="required">*</span></label>
                        <input type="password" id="coordinator-password" placeholder="Crie uma palavra-passe segura" required
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                               title="A palavra-passe deve conter pelo menos: 8 caracteres, 1 letra maiúscula, 1 letra minúscula e 1 número">
                        <small class="password-requirements">
                            Requisitos: mínimo 8 caracteres, incluindo pelo menos 1 letra maiúscula, 1 letra minúscula e 1 número
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="coordinator-confirm-password">Confirmar Palavra-passe <span class="required">*</span></label>
                        <input type="password" id="coordinator-confirm-password" placeholder="Repita a palavra-passe" required>
                        <small id="password-match-error" style="color: red; display: none;">As palavras-passe não coincidem</small>
                    </div>
                </fieldset>

                <div class="form-actions">
                    <button type="button" class="cancel-btn" id="cancel-coordinator-btn">Cancelar</button>
                    <button type="submit" class="save-btn">Salvar Coordenador</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Função para verificar se o Coordenador tem pelo menos 18 anos
    document.getElementById("coordinator-form").addEventListener("submit", function(event) {
        const dob = document.getElementById("coordinator-dob").value;
        const biNumber = document.getElementById("bi-number").value;
        
        // Verifica se a data de nascimento foi preenchida
        if (dob) {
            const birthDate = new Date(dob);
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age < 18) {
                alert("O Coordenador precisa ter pelo menos 18 anos.");
                event.preventDefault(); // Impede o envio do formulário
                return;
            }
        }

        // Valida o número do BI (com base no padrão)
        const biRegex = /^\d{7}[A-Za-z]{2}\d{3}$/;
        if (!biRegex.test(biNumber)) {
            alert("O número do Bilhete de Identidade (BI) não segue o formato correto.");
            event.preventDefault(); // Impede o envio do formulário
            return;
        }
    });
</script>

    <!-- Modal para visualizar detalhes do Coordenador -->
    <div class="modal view-modal" id="view-coordinator-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detalhes do Coordenador</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="coordinator-details">
                    <h4>Informações Pessoais</h4>
                    <div class="detail-row">
                        <div class="detail-label">Nome:</div>
                        <div class="detail-value" id="view-name"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Gênero:</div>
                        <div class="detail-value" id="view-gender"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Data de Nascimento:</div>
                        <div class="detail-value" id="view-dob"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">BI:</div>
                        <div class="detail-value" id="view-bi"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Endereço:</div>
                        <div class="detail-value" id="view-address"></div>
                    </div>
                    
                    <h4>Informações de Contato</h4>
                    <div class="detail-row">
                        <div class="detail-label">Contato:</div>
                        <div class="detail-value" id="view-contact"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email:</div>
                        <div class="detail-value" id="view-email"></div>
                    </div>
                    
                    <div class="students-list">
                        <h4>Educandos</h4>
                        <ul id="view-students"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerta para notificações -->
    <div id="alert-container"></div>

    <script>
    // Função para mostrar alerta
    function showAlert(message, type = 'success') {
        const alertContainer = document.getElementById('alert-container');
        const alertId = 'alert-' + Date.now();
        
        const alertHTML = `
            <div id="${alertId}" class="alert alert-${type}">
                <span>${message}</span>
                <button class="close-alert">&times;</button>
            </div>
        `;
        
        alertContainer.insertAdjacentHTML('beforeend', alertHTML);
        
        const alertElement = document.getElementById(alertId);
        
        // Fechar alerta ao clicar no botão de fechar
        alertElement.querySelector('.close-alert').addEventListener('click', function() {
            alertElement.classList.add('fade-out');
            setTimeout(() => {
                alertElement.remove();
            }, 300);
        });
        
        // Fechar automaticamente após 5 segundos
        setTimeout(() => {
            if (alertElement) {
                alertElement.classList.add('fade-out');
                setTimeout(() => {
                    if (alertElement.parentNode) {
                        alertElement.remove();
                    }
                }, 300);
            }
        }, 5000);
    }

    // Função para carregar os Coordenadores
    function loadcoordinators() {
        fetch('api/coordinators.php?action=get')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const coordinatorsList = data.data;
                    let html = '';
                    coordinatorsList.forEach(coordinator => {
                        html += `
                            <tr>
                                <td>${coordinator.id}</td>
                                <td>${coordinator.fname} ${coordinator.lname}</td>
                                <td>${coordinator.educando || 'Nenhum'}</td>
                                <td>${coordinator.contact}</td>
                                <td>
                                    <button class="view-btn" data-id="${coordinator.id}"><i class="fas fa-eye"></i> Ver</button>
                                    <button class="edit-btn" data-id="${coordinator.id}"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="delete-btn" data-id="${coordinator.id}"><i class="fas fa-trash"></i> Excluir</button>
                                </td>
                            </tr>
                        `;
                    });
                    document.getElementById('coordinator-table-body').innerHTML = html;
                    
                    // Adicionar event listeners para os botões
                    setupActionButtons();
                } else {
                    showAlert('Erro ao carregar os dados: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao conectar com o servidor', 'error');
            });
    }

    // Configurar event listeners para os botões de ação
    function setupActionButtons() {
        // Botão de visualizar
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                viewcoordinator(id);
            });
        });
        
        // Botão de editar
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                editcoordinator(id);
            });
        });
        
        // Botão de excluir
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                deletecoordinator(id);
            });
        });
    }

    // Função para visualizar um Coordenador
    function viewcoordinator(id) {
        fetch(`api/coordinators.php?action=getById&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const coordinator = data.data;
                    
                    // Preencher os campos do modal de visualização
                    document.getElementById('view-name').textContent = `${coordinator.fname} ${coordinator.lname}` || 'N/A';
                    document.getElementById('view-gender').textContent = coordinator.gender || 'N/A';
                    document.getElementById('view-dob').textContent = coordinator.dob ? new Date(coordinator.dob).toLocaleDateString() : 'N/A';
                    document.getElementById('view-bi').textContent = coordinator.bi_number || 'N/A';
                    document.getElementById('view-address').textContent = coordinator.address || 'N/A';
                    document.getElementById('view-contact').textContent = coordinator.contact || 'N/A';
                    document.getElementById('view-email').textContent = coordinator.email || 'N/A';
                    
                    // Preencher a lista de educandos
                    const studentsList = document.getElementById('view-students');
                    studentsList.innerHTML = '';
                    
                    if (coordinator.students && coordinator.students.length > 0) {
                        coordinator.students.forEach(student => {
                            const li = document.createElement('li');
                            li.textContent = student.name;
                            studentsList.appendChild(li);
                        });
                    } else {
                        const li = document.createElement('li');
                        li.textContent = 'Nenhum educando associado';
                        studentsList.appendChild(li);
                    }
                    
                    // Mostrar o modal
                    document.getElementById('view-coordinator-modal').style.display = 'block';
                } else {
                    showAlert('Erro ao carregar os dados do Coordenador: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao conectar com o servidor', 'error');
            });
    }

    // Função para editar um Coordenador
    function editcoordinator(id) {
        fetch(`api/coordinators.php?action=getById&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const coordinator = data.data;
                    
                    // Preencher os campos do formulário
                    document.getElementById('coordinator-id').value = coordinator.id;
                    document.getElementById('fname').value = coordinator.fname || '';
                    document.getElementById('lname').value = coordinator.lname || '';
                    document.getElementById('coordinator-gender').value = coordinator.gender || '';
                    document.getElementById('coordinator-dob').value = coordinator.dob || '';
                    document.getElementById('bi-number').value = coordinator.bi_number || '';
                    document.getElementById('coordinator-address').value = coordinator.address || '';
                    
                    // Separar o código do país e o número de telefone
                    let contact = coordinator.contact || '';
                    let countryCode = '+244'; // Padrão para Angola
                    let phoneNumber = contact;
                    
                    if (contact.startsWith('+')) {
                        const codeEnd = contact.indexOf(' ') > -1 ? contact.indexOf(' ') : 4;
                        countryCode = contact.substring(0, codeEnd);
                        phoneNumber = contact.substring(codeEnd).trim();
                    }
                    
                    document.getElementById('country-code').value = countryCode;
                    document.getElementById('coordinator-contact').value = phoneNumber;
                    document.getElementById('coordinator-email').value = coordinator.email || '';
                    document.getElementById('coordinator-username').value = coordinator.username || '';
                    
                    // Atualizar o título do modal
                    document.getElementById('coordinator-modal-title').textContent = 'Editar Coordenador';
                    
                    // Mostrar o modal
                    document.getElementById('coordinator-modal').style.display = 'block';
                } else {
                    showAlert('Erro ao carregar os dados do Coordenador: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao conectar com o servidor', 'error');
            });
    }

    // Função para excluir um Coordenador
    function deletecoordinator(id) {
        if (confirm('Tem certeza que deseja excluir este Coordenador?')) {
            fetch(`api/coordinators.php?action=delete&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Coordenador excluído com sucesso!');
                        loadcoordinators(); // Recarregar a lista
                    } else {
                        showAlert('Erro ao excluir Coordenador: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showAlert('Erro ao conectar com o servidor', 'error');
                });
        }
    }

    // Event listener para o formulário de Coordenador
    document.getElementById('coordinator-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
       // Validação de senha
    const password = document.getElementById('coordinator-password').value;
    const confirmPassword = document.getElementById('coordinator-confirm-password').value;
    
    if (password !== confirmPassword) {
        showAlert('As senhas não coincidem', 'error');
        return;
    }

    // Validação de campos obrigatórios
    const fname = document.getElementById('fname').value.trim();
    const lname = document.getElementById('lname').value.trim();
    
    if (!fname || !lname) {
        showAlert('Primeiro nome e último nome são obrigatórios', 'error');
        return;
    }

        // Validação de idade
        const dob = new Date(document.getElementById('coordinator-dob').value);
        const age = new Date().getFullYear() - dob.getFullYear();
        if (age < 18) {
            showAlert('O Coordenador precisa ter pelo menos 18 anos', 'error');
            return;
        }

        // Validação do BI
        const biNumber = document.getElementById('bi-number').value;
        if (!/^\d{7}[A-Za-z]{2}\d{3}$/.test(biNumber)) {
            showAlert('O número do BI não segue o formato correto (0000000LA000)', 'error');
            return;
        }

        // Preparar dados do formulário
        const formData = {
            fname: document.getElementById('fname').value.trim(),
            lname: document.getElementById('lname').value.trim(),
            username: document.getElementById('coordinator-username').value.trim(),
            gender: document.getElementById('coordinator-gender').value,
            dob: document.getElementById('coordinator-dob').value,
            bi_number: biNumber,
            address: document.getElementById('coordinator-address').value.trim(),
            contact: document.getElementById('country-code').value + ' ' + 
                     document.getElementById('coordinator-contact').value.trim(),
            email: document.getElementById('coordinator-email').value.trim(),
            password: password
        };

        const coordinatorId = document.getElementById('coordinator-id').value;
        const url = coordinatorId 
            ? `api/coordinators.php?action=update&id=${coordinatorId}` 
            : 'api/coordinators.php?action=create';
        
        // Enviar para o backend
        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(coordinatorId ? 'Coordenador atualizado com sucesso!' : 'Coordenador cadastrado com sucesso!');
                document.getElementById('coordinator-modal').style.display = 'none';
                document.getElementById('coordinator-form').reset();
                loadcoordinators(); // Recarregar a lista
            } else {
                showAlert('Erro: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert('Erro ao conectar com o servidor', 'error');
        });
    });

    // Event listener para o botão de adicionar Coordenador
    document.getElementById('add-coordinator-btn').addEventListener('click', function() {
        // Limpar o formulário
        document.getElementById('coordinator-form').reset();
        document.getElementById('coordinator-id').value = '';
        
        // Atualizar o título do modal
        document.getElementById('coordinator-modal-title').textContent = 'Adicionar Novo Coordenador';
        
        // Mostrar o modal
        document.getElementById('coordinator-modal').style.display = 'block';
    });

    // Event listener para o botão de cancelar
    document.getElementById('cancel-coordinator-btn').addEventListener('click', function() {
        document.getElementById('coordinator-modal').style.display = 'none';
    });

    // Event listeners para fechar os modais
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.modal').style.display = 'none';
        });
    });

    // Fechar o modal ao clicar fora dele
    window.addEventListener('click', function(event) {
        document.querySelectorAll('.modal').forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Event listener para o dropdown do usuário
    document.querySelector('.user-dropdown').addEventListener('click', function(e) {
        e.stopPropagation();
        this.querySelector('.dropdown-menu').classList.toggle('show');
    });

    // Fechar o dropdown ao clicar fora dele
    document.addEventListener('click', function() {
        document.querySelector('.dropdown-menu').classList.remove('show');
    });

    // Event listener para o campo de pesquisa
    document.getElementById('search-input').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#coordinator-table-body tr');
        
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const educando = row.cells[2].textContent.toLowerCase();
            const contact = row.cells[3].textContent.toLowerCase();
            
            if (name.includes(searchTerm) || educando.includes(searchTerm) || contact.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Funcionalidade da barra lateral
    document.querySelectorAll('.has-submenu .menu-item').forEach(item => {
        item.addEventListener('click', function() {
            const submenu = this.nextElementSibling;
            const isOpen = submenu.classList.contains('show');
            
            // Fechar todos os submenus
            document.querySelectorAll('.submenu').forEach(menu => {
                menu.classList.remove('show');
            });
            
            // Abrir o submenu clicado se estava fechado
            if (!isOpen) {
                submenu.classList.add('show');
            }
        });
    });

    // Carregar os Coordenadores ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        loadcoordinators();
    });
</script>
    </script>
</body>
</html>
<?php }else{
    header("Location: ../login.php");
    exit;
} ?>