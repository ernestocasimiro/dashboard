<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {

    ?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boletins - Sistema de Gestão Escolar</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
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
              <li class="has-submenu active" data-tab="pedagogical-management">
                  <div class="menu-item">
                      <i class="fas fa-chalkboard"></i> 
                      <span>Gestão Pedagógica</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu show">
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
                      <li class="active" data-tab="bulletins">
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
                      <li data-tab="register-teachers">
                          <a href="teachers.php">
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
              <!-- Gestão Pedagógica - Boletins -->
              <div class="tab-pane active" id="bulletins">
                  <div class="section-header">
                      <h2>Boletins</h2>
                      <button class="add-btn" id="create-bulletin-btn">
                          <i class="fas fa-plus"></i> Criar Boletim
                      </button>
                  </div>
                  
                  <div class="filter-controls">
                      <div class="dropdown-filter">
                          <select id="bulletin-class-filter">
                              <option value="">Todas as Turmas</option>
                              <option value="Turma 10ª A Informática">Turma 10ª A Informática</option>
                              <option value="Turma 10ª B Informática">Turma 10ª B Informática</option>
                              <option value="Turma 11ª Informática">Turma 11ª Informática</option>
                              <option value="Turma 12ª Informática">Turma 12ª Informática</option>
                              <option value="Turma 13ª Informática">Turma 13ª Informática</option>
                          </select>
                      </div>
                      <div class="dropdown-filter">
                          <select id="bulletin-period-filter">
                              <option value="">Todos os Períodos</option>
                              <option value="1">1º Trimestre</option>
                              <option value="2">2º Trimestre</option>
                              <option value="3">3º Trimestre</option>
                              <option value="final">Final</option>
                          </select>
                      </div>
                      <div class="search-filter">
                          <input type="text" id="bulletin-search" placeholder="Pesquisar alunos...">
                      </div>
                  </div>
                  
                  <div class="table-container">
                      <table class="data-table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Aluno</th>
                                  <th>Turma</th>
                                  <th>Período</th>
                                  <th>Média</th>
                                  <th>Situação</th>
                                  <th>Ações</th>
                              </tr>
                          </thead>
                          <tbody id="bulletin-table-body">
                              <tr>
                                  <td>BLT001</td>
                                  <td>João Silva</td>
                                  <td>Turma 10ª A Informática</td>
                                  <td>1º Trimestre</td>
                                  <td>15.7</td>
                                  <td><span class="status-badge present">Aprovado</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn print" title="Imprimir"><i class="fas fa-print"></i></button>
                                  </td>
                              </tr>
                              <tr>
                                  <td>BLT002</td>
                                  <td>Maria Santos</td>
                                  <td>Turma 10ª A Informática</td>
                                  <td>1º Trimestre</td>
                                  <td>17.2</td>
                                  <td><span class="status-badge present">Aprovado</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn print" title="Imprimir"><i class="fas fa-print"></i></button>
                                  </td>
                              </tr>
                              <tr>
                                  <td>BLT003</td>
                                  <td>Pedro Oliveira</td>
                                  <td>Turma 10ª B Informática</td>
                                  <td>1º Trimestre</td>
                                  <td>12.8</td>
                                  <td><span class="status-badge late">Recuperação</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn print" title="Imprimir"><i class="fas fa-print"></i></button>
                                  </td>
                              </tr>
                              <tr>
                                  <td>BLT004</td>
                                  <td>Ana Costa</td>
                                  <td>Turma 10ª A Informática</td>
                                  <td>1º Trimestre</td>
                                  <td>18.5</td>
                                  <td><span class="status-badge present">Aprovado</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn print" title="Imprimir"><i class="fas fa-print"></i></button>
                                  </td>
                              </tr>
                              <tr>
                                  <td>BLT005</td>
                                  <td>Carlos Ferreira</td>
                                  <td>Turma 11ª Informática</td>
                                  <td>1º Trimestre</td>
                                  <td>9.5</td>
                                  <td><span class="status-badge absent">Reprovado</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn print" title="Imprimir"><i class="fas fa-print"></i></button>
                                  </td>
                              </tr>
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
  
  <!-- Modal para criar/editar boletins -->
  <div class="modal" id="bulletin-modal">
      <div class="modal-content">
          <div class="modal-header">
              <h3 id="bulletin-modal-title">Criar Novo Boletim</h3>
              <span class="close-modal">&times;</span>
          </div>
          <div class="modal-body">
              <form id="bulletin-form">
                  <div class="form-row">
                      <div class="form-group">
                          <label for="bulletin-student">Aluno</label>
                          <select id="bulletin-student" required>
                              <option value="">Selecionar Aluno</option>
                              <option value="STU001">João Silva</option>
                              <option value="STU002">Maria Santos</option>
                              <option value="STU003">Pedro Oliveira</option>
                              <option value="STU004">Ana Costa</option>
                              <option value="STU005">Carlos Ferreira</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="bulletin-period">Período</label>
                          <select id="bulletin-period" required>
                              <option value="">Selecionar Período</option>
                              <option value="1">1º Trimestre</option>
                              <option value="2">2º Trimestre</option>
                              <option value="3">3º Trimestre</option>
                              <option value="final">Final</option>
                          </select>
                      </div>
                  </div>
                  
                  <h4 class="modal-section-title">Notas por Disciplina</h4>
                  <div class="grades-container">
                      <div class="form-row">
                          <div class="form-group">
                              <label for="grade-math">Matemática</label>
                              <input type="number" id="grade-math" min="0" max="20" step="0.1" required>
                          </div>
                          <div class="form-group">
                              <label for="grade-portuguese">Português</label>
                              <input type="number" id="grade-portuguese" min="0" max="20" step="0.1" required>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group">
                              <label for="grade-english">Inglês</label>
                              <input type="number" id="grade-english" min="0" max="20" step="0.1" required>
                          </div>
                          <div class="form-group">
                              <label for="grade-physics">Física</label>
                              <input type="number" id="grade-physics" min="0" max="20" step="0.1" required>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group">
                              <label for="grade-chemistry">Química</label>
                              <input type="number" id="grade-chemistry" min="0" max="20" step="0.1" required>
                          </div>
                          <div class="form-group">
                              <label for="grade-informatics">Informática</label>
                              <input type="number" id="grade-informatics" min="0" max="20" step="0.1" required>
                          </div>
                      </div>
                  </div>
                  
                  <div class="form-group">
                      <label for="bulletin-comments">Observações</label>
                      <textarea id="bulletin-comments" rows="3"></textarea>
                  </div>
                  
                  <div class="form-actions">
                      <button type="button" class="cancel-btn">Cancelar</button>
                      <button type="submit" class="save-btn">Salvar Boletim</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  
  <script src="js/script.js"></script>
</body>
</html>

<?php }else{
    header("Location: ../login.php");
    exit;
} ?>

