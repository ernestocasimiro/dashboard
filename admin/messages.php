<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mensagens - Pitruca Camama</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/messages.css">
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
                      <li class="active" data-tab="messages">
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
              <div class="tab-pane active" id="messages">
                  <h2>Sistema de Mensagens</h2>
                  
                  <div class="messages-container">
                      <div class="messages-sidebar">
                          <div class="messages-actions">
                              <button class="btn-compose"><i class="fas fa-plus"></i> Nova Mensagem</button>
                              <div class="messages-filters">
                                  <button class="filter-btn active" data-filter="inbox"><i class="fas fa-inbox"></i> Caixa de Entrada</button>
                                  <button class="filter-btn" data-filter="sent"><i class="fas fa-paper-plane"></i> Enviados</button>
                                  <button class="filter-btn" data-filter="draft"><i class="fas fa-save"></i> Rascunhos</button>
                                  <button class="filter-btn" data-filter="trash"><i class="fas fa-trash"></i> Lixeira</button>
                              </div>
                          </div>
                          
                          <div class="messages-list">
                              <div class="message-item unread" data-id="1">
                                  <div class="message-sender">
                                      <img src="login/images/semft-removebg-preview.png" alt="Avatar" class="sender-avatar">
                                      <div class="sender-info">
                                          <h4>Maria Oliveira</h4>
                                          <span class="message-time">10:30 AM</span>
                                      </div>
                                  </div>
                                  <div class="message-preview">
                                      <h5>Reunião de Pais</h5>
                                      <p>Prezado coordenador, gostaria de confirmar a data da próxima reunião de pais...</p>
                                  </div>
                              </div>
                              
                              <div class="message-item" data-id="2">
                                  <div class="message-sender">
                                      <img src="login/images/semft-removebg-preview.png" alt="Avatar" class="sender-avatar">
                                      <div class="sender-info">
                                          <h4>João Santos</h4>
                                          <span class="message-time">Ontem</span>
                                      </div>
                                  </div>
                                  <div class="message-preview">
                                      <h5>Material Didático</h5>
                                      <p>Solicito informações sobre o novo material didático para o próximo semestre...</p>
                                  </div>
                              </div>
                              
                              <div class="message-item" data-id="3">
                                  <div class="message-sender">
                                      <img src="login/images/semft-removebg-preview.png" alt="Avatar" class="sender-avatar">
                                      <div class="sender-info">
                                          <h4>Ana Silva</h4>
                                          <span class="message-time">23 Ago</span>
                                      </div>
                                  </div>
                                  <div class="message-preview">
                                      <h5>Dúvida sobre avaliação</h5>
                                      <p>Bom dia, gostaria de esclarecer algumas dúvidas sobre o sistema de avaliação...</p>
                                  </div>
                              </div>
                              
                              <div class="message-item" data-id="4">
                                  <div class="message-sender">
                                      <img src="login/images/semft-removebg-preview.png" alt="Avatar" class="sender-avatar">
                                      <div class="sender-info">
                                          <h4>Carlos Mendes</h4>
                                          <span class="message-time">20 Ago</span>
                                      </div>
                                  </div>
                                  <div class="message-preview">
                                      <h5>Solicitação de reunião</h5>
                                      <p>Prezado diretor, solicito uma reunião para discutir o desempenho do meu filho...</p>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                      <div class="message-detail">
                          <div class="message-header">
                              <div class="message-subject">
                                  <h3>Reunião de Pais</h3>
                                  <div class="message-meta">
                                      <span class="sender-name">De: Maria Oliveira</span>
                                      <span class="message-date">Hoje, 10:30 AM</span>
                                  </div>
                              </div>
                              <div class="message-actions">
                                  <button class="action-btn" title="Responder"><i class="fas fa-reply"></i></button>
                                  <button class="action-btn" title="Encaminhar"><i class="fas fa-share"></i></button>
                                  <button class="action-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                              </div>
                          </div>
                          
                          <div class="message-body">
                              <p>Prezado coordenador,</p>
                              <p>Gostaria de confirmar a data da próxima reunião de pais e mestres. No último comunicado, foi mencionado que seria no dia 15 de setembro, mas não foi especificado o horário.</p>
                              <p>Também gostaria de saber se haverá uma pauta específica para esta reunião ou se será uma discussão geral sobre o desempenho dos alunos.</p>
                              <p>Agradeço antecipadamente pela atenção.</p>
                              <p>Atenciosamente,<br>Maria Oliveira<br>Mãe do aluno Pedro Oliveira - 5º ano B</p>
                          </div>
                          
                          <div class="message-reply">
                              <textarea placeholder="Escreva sua resposta aqui..."></textarea>
                              <div class="reply-actions">
                                  <button class="btn-send"><i class="fas fa-paper-plane"></i> Enviar</button>
                                  <button class="btn-attach"><i class="fas fa-paperclip"></i></button>
                              </div>
                          </div>
                      </div>
                  </div>
                  
                  <!-- Modal para nova mensagem -->
                  <div class="compose-modal" id="composeModal">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h3>Nova Mensagem</h3>
                              <button class="close-modal"><i class="fas fa-times"></i></button>
                          </div>
                          <div class="modal-body">
                              <form id="composeForm">
                                  <div class="form-group">
                                      <label for="recipient">Para:</label>
                                      <input type="text" id="recipient" placeholder="Digite o nome ou selecione o destinatário">
                                  </div>
                                  <div class="form-group">
                                      <label for="subject">Assunto:</label>
                                      <input type="text" id="subject" placeholder="Assunto da mensagem">
                                  </div>
                                  <div class="form-group">
                                      <label for="message">Mensagem:</label>
                                      <textarea id="message" rows="10" placeholder="Escreva sua mensagem aqui..."></textarea>
                                  </div>
                                  <div class="form-actions">
                                      <button type="button" class="btn-attach"><i class="fas fa-paperclip"></i> Anexar</button>
                                      <button type="submit" class="btn-send"><i class="fas fa-paper-plane"></i> Enviar</button>
                                      <button type="button" class="btn-save"><i class="fas fa-save"></i> Salvar Rascunho</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </main>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get the user dropdown element
      const userDropdown = document.querySelector('.user-dropdown');
      const dropdownMenu = document.querySelector('.dropdown-menu');
      
      // Toggle dropdown when username is clicked
      userDropdown.addEventListener('click', function() {
        dropdownMenu.classList.toggle('show');
      });
      
      // Close dropdown when clicking outside
      document.addEventListener('click', function(event) {
        if (!userDropdown.contains(event.target)) {
          dropdownMenu.classList.remove('show');
        }
      });
      
      // No special automatic display - dropdown only shows when clicked
    });
  </script>
  
  <script src="js/script.js"></script>
  <script src="js/messages.js"></script>
</body>
</html>

<?php } else {
    header("Location: ../login.php");
    exit;
} ?>
