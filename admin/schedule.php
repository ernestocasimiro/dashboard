<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Horários - Sistema de Gestão Escolar</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                      <li class="active" data-tab="schedule">
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
          <div class="logout">
              <i class="fas fa-sign-out-alt"></i> 
              <span>Sair</span>
          </div>
      </nav>
      
      <main class="content">
          <header>
              <div class="search-bar">
                  <i class="fas fa-search"></i>
                  <input type="text" placeholder="Pesquisar...">
              </div>
              <div class="user-info">
                  <div class="notifications">
                      <i class="fas fa-bell"></i>
                      <span class="badge">3</span>
                  </div>
                  <div class="user">
                      <img src="images/semfoto.jpeg" alt="Admin User">
                      <span>Administrador</span>
                  </div>
              </div>
          </header>
          
          <div class="tab-content">
              <!-- Gestão Pedagógica - Horários -->
              <div class="tab-pane active" id="schedule">
                  <div class="section-header">
                      <h2>Horários</h2>
                      <button class="add-btn" id="add-schedule-btn">
                          <i class="fas fa-plus"></i> Adicionar Horário
                      </button>
                  </div>
                  
                  <div class="filter-controls">
                      <div class="dropdown-filter">
                          <select id="schedule-class-filter">
                              <option value="">Selecionar Turma</option>
                              <option value="Turma 10ª A Informática">Turma 10ª A Informática</option>
                              <option value="Turma 10ª B Informática">Turma 10ª B Informática</option>
                              <option value="Turma 11ª Informática">Turma 11ª Informática</option>
                              <option value="Turma 12ª Informática">Turma 12ª Informática</option>
                              <option value="Turma 13ª Informática">Turma 13ª Informática</option>
                          </select>
                      </div>
                      <div class="dropdown-filter">
                          <select id="schedule-day-filter">
                              <option value="">Todos os Dias</option>
                              <option value="monday">Segunda-feira</option>
                              <option value="tuesday">Terça-feira</option>
                              <option value="wednesday">Quarta-feira</option>
                              <option value="thursday">Quinta-feira</option>
                              <option value="friday">Sexta-feira</option>
                          </select>
                      </div>
                  </div>
                  
                  <div class="schedule-container">
                      <table class="schedule-table">
                          <thead>
                              <tr>
                                  <th>Hora</th>
                                  <th>Segunda-feira</th>
                                  <th>Terça-feira</th>
                                  <th>Quarta-feira</th>
                                  <th>Quinta-feira</th>
                                  <th>Sexta-feira</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td>08:00 - 09:30</td>
                                  <td class="schedule-cell">
                                      <div class="subject-card math">
                                          <h4>Matemática</h4>
                                          <p>Prof. Ana Costa</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card science">
                                          <h4>Física</h4>
                                          <p>Prof. Carlos Ferreira</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card language">
                                          <h4>Português</h4>
                                          <p>Prof. Maria Santos</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card math">
                                          <h4>Matemática</h4>
                                          <p>Prof. Ana Costa</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card tech">
                                          <h4>Informática</h4>
                                          <p>Prof. Pedro Silva</p>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>09:45 - 11:15</td>
                                  <td class="schedule-cell">
                                      <div class="subject-card language">
                                          <h4>Inglês</h4>
                                          <p>Prof. João Oliveira</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card math">
                                          <h4>Matemática</h4>
                                          <p>Prof. Ana Costa</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card science">
                                          <h4>Química</h4>
                                          <p>Prof. Carlos Ferreira</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card language">
                                          <h4>Português</h4>
                                          <p>Prof. Maria Santos</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card language">
                                          <h4>Inglês</h4>
                                          <p>Prof. João Oliveira</p>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>11:30 - 13:00</td>
                                  <td class="schedule-cell">
                                      <div class="subject-card tech">
                                          <h4>Informática</h4>
                                          <p>Prof. Pedro Silva</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card language">
                                          <h4>Português</h4>
                                          <p>Prof. Maria Santos</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card tech">
                                          <h4>Informática</h4>
                                          <p>Prof. Pedro Silva</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card science">
                                          <h4>Física</h4>
                                          <p>Prof. Carlos Ferreira</p>
                                      </div>
                                  </td>
                                  <td class="schedule-cell">
                                      <div class="subject-card science">
                                          <h4>Química</h4>
                                          <p>Prof. Carlos Ferreira</p>
                                      </div>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </main>
  </div>
  
  <!-- Modal para adicionar/editar horários -->
  <div class="modal" id="schedule-modal">
      <div class="modal-content">
          <div class="modal-header">
              <h3 id="schedule-modal-title">Adicionar Novo Horário</h3>
              <span class="close-modal">&times;</span>
          </div>
          <div class="modal-body">
              <form id="schedule-form">
                  <div class="form-group">
                      <label for="schedule-class">Turma</label>
                      <select id="schedule-class" required>
                          <option value="">Selecionar Turma</option>
                          <option value="CLS001">Turma 10ª A Informática</option>
                          <option value="CLS002">Turma 10ª B Informática</option>
                          <option value="CLS003">Turma 11ª Informática</option>
                          <option value="CLS004">Turma 12ª Informática</option>
                          <option value="CLS005">Turma 13ª Informática</option>
                      </select>
                  </div>
                  <div class="form-row">
                      <div class="form-group">
                          <label for="schedule-day">Dia da Semana</label>
                          <select id="schedule-day" required>
                              <option value="">Selecionar Dia</option>
                              <option value="monday">Segunda-feira</option>
                              <option value="tuesday">Terça-feira</option>
                              <option value="wednesday">Quarta-feira</option>
                              <option value="thursday">Quinta-feira</option>
                              <option value="friday">Sexta-feira</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="schedule-time">Horário</label>
                          <select id="schedule-time" required>
                              <option value="">Selecionar Horário</option>
                              <option value="1">08:00 - 09:30</option>
                              <option value="2">09:45 - 11:15</option>
                              <option value="3">11:30 - 13:00</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group">
                          <label for="schedule-subject">Disciplina</label>
                          <select id="schedule-subject" required>
                              <option value="">Selecionar Disciplina</option>
                              <option value="math">Matemática</option>
                              <option value="portuguese">Português</option>
                              <option value="english">Inglês</option>
                              <option value="physics">Física</option>
                              <option value="chemistry">Química</option>
                              <option value="informatics">Informática</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="schedule-teacher">Professor</label>
                          <select id="schedule-teacher" required>
                              <option value="">Selecionar Professor</option>
                              <option value="1">Maria Santos</option>
                              <option value="2">João Oliveira</option>
                              <option value="3">Ana Costa</option>
                              <option value="4">Carlos Ferreira</option>
                              <option value="5">Pedro Silva</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-actions">
                      <button type="button" class="cancel-btn">Cancelar</button>
                      <button type="submit" class="save-btn">Salvar Horário</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  
  <script src="js/script.js"></script>
</body>
</html>

