<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
?>


<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema - Pitruca Camama</title>
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
                  <div class="menu-item">
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
                      <li data-tab="register-teachers">
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
                          <a href="guardians.html">
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
                          <a href="messages.html">
                              <i class="fas fa-envelope"></i> 
                              <span>Mensagens</span>
                          </a>
                      </li>
                      <li data-tab="notice-board">
                          <a href="notices.html">
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
                          <a href="finances.html">
                              <i class="fas fa-chart-line"></i> 
                              <span>Gestão Financeira</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Configurações -->
              <li data-tab="settings">
                  <a href="settings.html">
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
              <!-- Painel (Visão Geral) -->
              <div class="tab-pane active" id="dashboard">
                  <h2>Painel (Visão Geral)</h2><br>
                  <div class="stats-container">
                      <div class="stat-card">
                          <div class="stat-icon student-icon">
                              <i class="fas fa-user-graduate"></i>
                          </div>
                          <div class="stat-info">
                              <h3>Total de Alunos</h3>
                              <p>1,250</p>
                          </div>
                      </div>
                      <div class="stat-card">
                          <div class="stat-icon teacher-icon">
                              <i class="fas fa-chalkboard-teacher"></i>
                          </div>
                          <div class="stat-info">
                              <h3>Total de Professores</h3>
                              <p>75</p>
                          </div>
                      </div>
                      <div class="stat-card">
                          <div class="stat-icon course-icon">
                              <i class="fas fa-book"></i>
                          </div>
                          <div class="stat-info">
                              <h3>Total de Turmas</h3>
                              <p>42</p>
                          </div>
                      </div>
                  </div>
                  
                  <div class="charts-container">
                      <div class="chart">
                          <h3>Visão Geral de Presença</h3>
                          <div class="chart-placeholder">
                              <div class="bar" style="height: 70%;" data-value="70%">
                                  <span>Seg</span>
                              </div>
                              <div class="bar" style="height: 85%;" data-value="85%">
                                  <span>Ter</span>
                              </div>
                              <div class="bar" style="height: 75%;" data-value="75%">
                                  <span>Qua</span>
                              </div>
                              <div class="bar" style="height: 90%;" data-value="90%">
                                  <span>Qui</span>
                              </div>
                              <div class="bar" style="height: 65%;" data-value="65%">
                                  <span>Sex</span>
                              </div>
                          </div>
                      </div>
                   
                  
                  <div class="recent-activity">
                      <h3>Atividade Recente</h3>
                      <div class="activity-list">
                          <div class="activity-item">
                              <div class="activity-icon">
                                  <i class="fas fa-user-plus"></i>
                              </div>
                              <div class="activity-details">
                                  <p>Novo aluno <strong>João Silva</strong> registrado</p>
                                  <span class="time">2 horas atrás</span>
                              </div>
                          </div>
                          <div class="activity-item">
                              <div class="activity-icon">
                                  <i class="fas fa-file-alt"></i>
                              </div>
                              <div class="activity-details">
                                  <p>Professor <strong>Maria Santos</strong> carregou novos materiais do curso</p>
                                  <span class="time">4 horas atrás</span>
                              </div>
                          </div>
                          <div class="activity-item">
                              <div class="activity-icon">
                                  <i class="fas fa-calendar-check"></i>
                              </div>
                              <div class="activity-details">
                                  <p>Presença para <strong>Turma 10B</strong> foi atualizada</p>
                                  <span class="time">Ontem</span>
                              </div>
                          </div>
                          <div class="activity-item">
                              <div class="activity-icon">
                                  <i class="fas fa-graduation-cap"></i>
                              </div>
                              <div class="activity-details">
                                  <p>Cronograma de exame final para <strong>Semestre de Primavera</strong> publicado</p>
                                  <span class="time">2 dias atrás</span>
                              </div>
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
</body>
</html>

<?php }else{
    header("Location: ../login.php");
    exit;
} ?>

