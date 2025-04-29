<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Provas - Sistema de Gestão Escolar</title>
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
                      <li data-tab="schedule">
                          <a href="schedule.php">
                              <i class="fas fa-calendar-alt"></i> 
                              <span>Horários</span>
                          </a>
                      </li>
                      <li class="active" data-tab="tests">
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
                              <span>Professores</span>
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
              <!-- Gestão Pedagógica - Provas -->
              <div class="tab-pane active" id="tests">
                  <div class="section-header">
                      <h2>Provas e Exames</h2>
                      <button class="add-btn" id="add-test-btn">
                          <i class="fas fa-plus"></i> Agendar Prova
                      </button>
                  </div>
                  
                  <div class="filter-controls">
                      <div class="dropdown-filter">
                          <select id="test-class-filter">
                              <option value="">Todas as Turmas</option>
                              <option value="Turma 10ª A Informática">Turma 10ª A Informática</option>
                              <option value="Turma 10ª B Informática">Turma 10ª B Informática</option>
                              <option value="Turma 11ª Informática">Turma 11ª Informática</option>
                              <option value="Turma 12ª Informática">Turma 12ª Informática</option>
                              <option value="Turma 13ª Informática">Turma 13ª Informática</option>
                          </select>
                      </div>
                      <div class="dropdown-filter">
                          <select id="test-subject-filter">
                              <option value="">Todas as Disciplinas</option>
                              <option value="math">Matemática</option>
                              <option value="portuguese">Português</option>
                              <option value="english">Inglês</option>
                              <option value="physics">Física</option>
                              <option value="chemistry">Química</option>
                              <option value="informatics">Informática</option>
                          </select>
                      </div>
                      <div class="dropdown-filter">
                          <select id="test-status-filter">
                              <option value="">Todos os Estados</option>
                              <option value="scheduled">Agendado</option>
                              <option value="in-progress">Em Processo</option>
                              <option value="completed">Concluído</option>
                          </select>
                      </div>
                      <div class="search-filter">
                          <input type="text" id="test-search" placeholder="Pesquisar provas...">
                      </div>
                  </div>
                  
                  <div class="table-container">
                      <table class="data-table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Disciplina</th>
                                  <th>Turma</th>
                                  <th>Data</th>
                                  <th>Hora</th>
                                  <th>Professor</th>
                                  <th>Estado</th>
                                  <th>Ações</th>
                              </tr>
                          </thead>
                          <tbody id="test-table-body">
                              <tr>
                                  <td>TST001</td>
                                  <td>Matemática</td>
                                  <td>Turma 10ª A Informática</td>
                                  <td>15/04/2025</td>
                                  <td>08:00 - 10:00</td>
                                  <td>Ana Costa</td>
                                  <td><span class="status-badge scheduled">Agendado</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn delete" title="Eliminar"><i class="fas fa-trash"></i></button>
                                  </td>
                              </tr>
                              <tr>
                                  <td>TST002</td>
                                  <td>Português</td>
                                  <td>Turma 10ª B Informática</td>
                                  <td>16/04/2025</td>
                                  <td>10:30 - 12:30</td>
                                  <td>Maria Santos</td>
                                  <td><span class="status-badge scheduled">Agendado</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn delete" title="Eliminar"><i class="fas fa-trash"></i></button>
                                  </td>
                              </tr>
                              <tr>
                                  <td>TST003</td>
                                  <td>Física</td>
                                  <td>Turma 11ª Informática</td>
                                  <td>10/04/2025</td>
                                  <td>08:00 - 10:00</td>
                                  <td>Carlos Ferreira</td>
                                  <td><span class="status-badge in-progress">Em Processo</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn delete" title="Eliminar"><i class="fas fa-trash"></i></button>
                                  </td>
                              </tr>
                              <tr>
                                  <td>TST004</td>
                                  <td>Informática</td>
                                  <td>Turma 12ª Informática</td>
                                  <td>05/04/2025</td>
                                  <td>13:00 - 15:00</td>
                                  <td>Pedro Silva</td>
                                  <td><span class="status-badge completed">Concluído</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn delete" title="Eliminar"><i class="fas fa-trash"></i></button>
                                  </td>
                              </tr>
                              <tr>
                                  <td>TST005</td>
                                  <td>Inglês</td>
                                  <td>Turma 13ª Informática</td>
                                  <td>02/04/2025</td>
                                  <td>10:30 - 12:30</td>
                                  <td>João Oliveira</td>
                                  <td><span class="status-badge completed">Concluído</span></td>
                                  <td>
                                      <button class="action-btn edit" title="Editar"><i class="fas fa-edit"></i></button>
                                      <button class="action-btn view" title="Ver"><i class="fas fa-eye"></i></button>
                                      <button class="action-btn delete" title="Eliminar"><i class="fas fa-trash"></i></button>
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
  
  <!-- Modal para agendar/editar provas -->
  <div class="modal" id="test-modal">
      <div class="modal-content">
          <div class="modal-header">
              <h3 id="test-modal-title">Agendar Nova Prova</h3>
              <span class="close-modal">&times;</span>
          </div>
          <div class="modal-body">
              <form id="test-form">
                  <div class="form-row">
                      <div class="form-group">
                          <label for="test-subject">Disciplina</label>
                          <select id="test-subject" required>
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
                          <label for="test-class">Turma</label>
                          <select id="test-class" required>
                              <option value="">Selecionar Turma</option>
                              <option value="CLS001">Turma 10ª A Informática</option>
                              <option value="CLS002">Turma 10ª B Informática</option>
                              <option value="CLS003">Turma 11ª Informática</option>
                              <option value="CLS004">Turma 12ª Informática</option>
                              <option value="CLS005">Turma 13ª Informática</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group">
                          <label for="test-date">Data</label>
                          <input type="date" id="test-date" required>
                      </div>
                      <div class="form-group">
                          <label for="test-time">Horário</label>
                          <select id="test-time" required>
                              <option value="">Selecionar Horário</option>
                              <option value="1">08:00 - 10:00</option>
                              <option value="2">10:30 - 12:30</option>
                              <option value="3">13:00 - 15:00</option>
                              <option value="4">15:30 - 17:30</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group">
                          <label for="test-teacher">Professor</label>
                          <select id="test-teacher" required>
                              <option value="">Selecionar Professor</option>
                              <option value="1">Maria Santos</option>
                              <option value="2">João Oliveira</option>
                              <option value="3">Ana Costa</option>
                              <option value="4">Carlos Ferreira</option>
                              <option value="5">Pedro Silva</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="test-status">Estado</label>
                          <select id="test-status" required>
                              <option value="scheduled">Agendado</option>
                              <option value="in-progress">Em Processo</option>
                              <option value="completed">Concluído</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="test-description">Descrição</label>
                      <textarea id="test-description" rows="3"></textarea>
                  </div>
                  <div class="form-actions">
                      <button type="button" class="cancel-btn">Cancelar</button>
                      <button type="submit" class="save-btn">Salvar Prova</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  
  <script src="js/script.js"></script>
</body>
</html>

