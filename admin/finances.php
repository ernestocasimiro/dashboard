<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestão Financeira - Pitruca Camama</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/finances.css">
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
                      <li class="active" data-tab="financial-management">
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
              <div class="tab-pane active" id="finances">
                  <div class="finances-header">
                      <h2>Gestão Financeira</h2>
                      <div class="period-selector">
                          <button class="period-btn active" data-period="month">Mês</button>
                          <button class="period-btn" data-period="quarter">Trimestre</button>
                          <button class="period-btn" data-period="year">Ano</button>
                          <div class="date-range">
                              <input type="month" id="financeMonth" value="<?php echo date('Y-m'); ?>">
                          </div>
                      </div>
                  </div>
                  
                  <div class="finance-summary">
                      <div class="summary-card income">
                          <div class="summary-icon">
                              <i class="fas fa-arrow-down"></i>
                          </div>
                          <div class="summary-details">
                              <h3>Receitas</h3>
                              <p class="amount">AOA 1,250,000</p>
                              <p class="trend positive">+15% <span>vs. mês anterior</span></p>
                          </div>
                      </div>
                      
                      <div class="summary-card expenses">
                          <div class="summary-icon">
                              <i class="fas fa-arrow-up"></i>
                          </div>
                          <div class="summary-details">
                              <h3>Despesas</h3>
                              <p class="amount">AOA 850,000</p>
                              <p class="trend negative">+5% <span>vs. mês anterior</span></p>
                          </div>
                      </div>
                      
                      <div class="summary-card balance">
                          <div class="summary-icon">
                              <i class="fas fa-wallet"></i>
                          </div>
                          <div class="summary-details">
                              <h3>Saldo</h3>
                              <p class="amount">AOA 400,000</p>
                              <p class="trend positive">+45% <span>vs. mês anterior</span></p>
                          </div>
                      </div>
                      
                      <div class="summary-card pending">
                          <div class="summary-icon">
                              <i class="fas fa-clock"></i>
                          </div>
                          <div class="summary-details">
                              <h3>Pendentes</h3>
                              <p class="amount">AOA 320,000</p>
                              <p class="trend negative">+8% <span>vs. mês anterior</span></p>
                          </div>
                      </div>
                  </div>
                  
                  <div class="finance-charts">
                      <div class="chart-container">
                          <div class="chart-header">
                              <h3>Receitas vs. Despesas</h3>
                              <div class="chart-actions">
                                  <button class="btn-export"><i class="fas fa-download"></i> Exportar</button>
                              </div>
                          </div>
                          <div class="chart-content">
                              <div class="chart-placeholder">
                                  <div class="chart-bars">
                                      <div class="month-group">
                                          <div class="bar-group">
                                              <div class="bar income-bar" style="height: 70%;" data-value="AOA 1,100,000"></div>
                                              <div class="bar expense-bar" style="height: 50%;" data-value="AOA 800,000"></div>
                                          </div>
                                          <span class="month-label">Jan</span>
                                      </div>
                                      <div class="month-group">
                                          <div class="bar-group">
                                              <div class="bar income-bar" style="height: 65%;" data-value="AOA 1,050,000"></div>
                                              <div class="bar expense-bar" style="height: 55%;" data-value="AOA 850,000"></div>
                                          </div>
                                          <span class="month-label">Fev</span>
                                      </div>
                                      <div class="month-group">
                                          <div class="bar-group">
                                              <div class="bar income-bar" style="height: 80%;" data-value="AOA 1,200,000"></div>
                                              <div class="bar expense-bar" style="height: 60%;" data-value="AOA 900,000"></div>
                                          </div>
                                          <span class="month-label">Mar</span>
                                      </div>
                                      <div class="month-group">
                                          <div class="bar-group">
                                              <div class="bar income-bar" style="height: 75%;" data-value="AOA 1,150,000"></div>
                                              <div class="bar expense-bar" style="height: 45%;" data-value="AOA 750,000"></div>
                                          </div>
                                          <span class="month-label">Abr</span>
                                      </div>
                                      <div class="month-group">
                                          <div class="bar-group">
                                              <div class="bar income-bar" style="height: 85%;" data-value="AOA 1,250,000"></div>
                                              <div class="bar expense-bar" style="height: 55%;" data-value="AOA 850,000"></div>
                                          </div>
                                          <span class="month-label">Mai</span>
                                      </div>
                                      <div class="month-group">
                                          <div class="bar-group">
                                              <div class="bar income-bar" style="height: 90%;" data-value="AOA 1,300,000"></div>
                                              <div class="bar expense-bar" style="height: 65%;" data-value="AOA 950,000"></div>
                                          </div>
                                          <span class="month-label">Jun</span>
                                      </div>
                                  </div>
                                  <div class="chart-legend">
                                      <div class="legend-item">
                                          <span class="legend-color income-color"></span>
                                          <span class="legend-label">Receitas</span>
                                      </div>
                                      <div class="legend-item">
                                          <span class="legend-color expense-color"></span>
                                          <span class="legend-label">Despesas</span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                      <div class="chart-container">
                          <div class="chart-header">
                              <h3>Distribuição de Despesas</h3>
                              <div class="chart-actions">
                                  <button class="btn-export"><i class="fas fa-download"></i> Exportar</button>
                              </div>
                          </div>
                          <div class="chart-content">
                              <div class="pie-chart-placeholder">
                                  <div class="pie-chart">
                                      <div class="pie-segment" style="--percentage: 45%; --color: #4caf50;">
                                          <span class="segment-label">Salários</span>
                                      </div>
                                      <div class="pie-segment" style="--percentage: 20%; --color: #2196f3;">
                                          <span class="segment-label">Materiais</span>
                                      </div>
                                      <div class="pie-segment" style="--percentage: 15%; --color: #ff9800;">
                                          <span class="segment-label">Infraestrutura</span>
                                      </div>
                                      <div class="pie-segment" style="--percentage: 10%; --color: #9c27b0;">
                                          <span class="segment-label">Serviços</span>
                                      </div>
                                      <div class="pie-segment" style="--percentage: 10%; --color: #f44336;">
                                          <span class="segment-label">Outros</span>
                                      </div>
                                  </div>
                                  <div class="pie-legend">
                                      <div class="legend-item">
                                          <span class="legend-color" style="background-color: #4caf50;"></span>
                                          <span class="legend-label">Salários (45%)</span>
                                      </div>
                                      <div class="legend-item">
                                          <span class="legend-color" style="background-color: #2196f3;"></span>
                                          <span class="legend-label">Materiais (20%)</span>
                                      </div>
                                      <div class="legend-item">
                                          <span class="legend-color" style="background-color: #ff9800;"></span>
                                          <span class="legend-label">Infraestrutura (15%)</span>
                                      </div>
                                      <div class="legend-item">
                                          <span class="legend-color" style="background-color: #9c27b0;"></span>
                                          <span class="legend-label">Serviços (10%)</span>
                                      </div>
                                      <div class="legend-item">
                                          <span class="legend-color" style="background-color: #f44336;"></span>
                                          <span class="legend-label">Outros (10%)</span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  
                  <div class="finance-tabs">
                      <div class="tabs-header">
                          <button class="tab-btn active" data-tab="transactions">Transações</button>
                          <button class="tab-btn" data-tab="tuition">Mensalidades</button>
                          <button class="tab-btn" data-tab="payroll">Folha de Pagamento</button>
                          <button class="tab-btn" data-tab="budget">Orçamento</button>
                      </div>
                      
                      <div class="tabs-content">
                          <div class="tab-panel active" id="transactions-panel">
                              <div class="panel-header">
                                  <h3>Transações Recentes</h3>
                                  <div class="panel-actions">
                                      <button class="btn-add-transaction"><i class="fas fa-plus"></i> Nova Transação</button>
                                      <div class="filter-dropdown">
                                          <button class="btn-filter"><i class="fas fa-filter"></i> Filtrar</button>
                                          <div class="filter-menu">
                                              <label><input type="checkbox" checked> Receitas</label>
                                              <label><input type="checkbox" checked> Despesas</label>
                                              <div class="filter-divider"></div>
                                              <label>Data Inicial: <input type="date"></label>
                                              <label>Data Final: <input type="date"></label>
                                              <button class="btn-apply-filter">Aplicar</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              
                              <div class="transactions-table">
                                  <table>
                                      <thead>
                                          <tr>
                                              <th>ID</th>
                                              <th>Data</th>
                                              <th>Descrição</th>
                                              <th>Categoria</th>
                                              <th>Valor</th>
                                              <th>Status</th>
                                              <th>Ações</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr class="income-row">
                                              <td>#TRX001</td>
                                              <td>05/05/2023</td>
                                              <td>Mensalidade - João Silva</td>
                                              <td>Mensalidades</td>
                                              <td class="amount positive">AOA 25,000</td>
                                              <td><span class="status-badge completed">Concluído</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Editar"><i class="fas fa-edit"></i></button>
                                                  <button class="action-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                          <tr class="expense-row">
                                              <td>#TRX002</td>
                                              <td>10/05/2023</td>
                                              <td>Pagamento de Energia</td>
                                              <td>Serviços</td>
                                              <td class="amount negative">AOA 45,000</td>
                                              <td><span class="status-badge completed">Concluído</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Editar"><i class="fas fa-edit"></i></button>
                                                  <button class="action-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                          <tr class="income-row">
                                              <td>#TRX003</td>
                                              <td>12/05/2023</td>
                                              <td>Mensalidade - Maria Oliveira</td>
                                              <td>Mensalidades</td>
                                              <td class="amount positive">AOA 25,000</td>
                                              <td><span class="status-badge completed">Concluído</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Editar"><i class="fas fa-edit"></i></button>
                                                  <button class="action-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                          <tr class="expense-row">
                                              <td>#TRX004</td>
                                              <td>15/05/2023</td>
                                              <td>Material Didático</td>
                                              <td>Materiais</td>
                                              <td class="amount negative">AOA 75,000</td>
                                              <td><span class="status-badge completed">Concluído</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Editar"><i class="fas fa-edit"></i></button>
                                                  <button class="action-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                          <tr class="income-row">
                                              <td>#TRX005</td>
                                              <td>18/05/2023</td>
                                              <td>Mensalidade - Carlos Santos</td>
                                              <td>Mensalidades</td>
                                              <td class="amount positive">AOA 25,000</td>
                                              <td><span class="status-badge pending">Pendente</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Editar"><i class="fas fa-edit"></i></button>
                                                  <button class="action-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                          <tr class="expense-row">
                                              <td>#TRX006</td>
                                              <td>20/05/2023</td>
                                              <td>Manutenção Predial</td>
                                              <td>Infraestrutura</td>
                                              <td class="amount negative">AOA 120,000</td>
                                              <td><span class="status-badge completed">Concluído</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Editar"><i class="fas fa-edit"></i></button>
                                                  <button class="action-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                          <tr class="income-row">
                                              <td>#TRX007</td>
                                              <td>22/05/2023</td>
                                              <td>Mensalidade - Ana Silva</td>
                                              <td>Mensalidades</td>
                                              <td class="amount positive">AOA 25,000</td>
                                              <td><span class="status-badge pending">Pendente</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Editar"><i class="fas fa-edit"></i></button>
                                                  <button class="action-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                              
                              <div class="pagination">
                                  <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                                  <button class="page-btn active">1</button>
                                  <button class="page-btn">2</button>
                                  <button class="page-btn">3</button>
                                  <span class="page-ellipsis">...</span>
                                  <button class="page-btn">10</button>
                                  <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                              </div>
                          </div>
                          
                          <div class="tab-panel" id="tuition-panel">
                              <div class="panel-header">
                                  <h3>Gestão de Mensalidades</h3>
                                  <div class="panel-actions">
                                      <button class="btn-generate-invoices"><i class="fas fa-file-invoice-dollar"></i> Gerar Faturas</button>
                                      <button class="btn-send-reminders"><i class="fas fa-bell"></i> Enviar Lembretes</button>
                                  </div>
                              </div>
                              
                              <div class="tuition-summary">
                                  <div class="tuition-stat">
                                      <h4>Total de Mensalidades</h4>
                                      <p class="stat-value">AOA 1,250,000</p>
                                  </div>
                                  <div class="tuition-stat">
                                      <h4>Pagas</h4>
                                      <p class="stat-value">AOA 875,000 <span class="stat-percentage">(70%)</span></p>
                                  </div>
                                  <div class="tuition-stat">
                                      <h4>Pendentes</h4>
                                      <p class="stat-value">AOA 375,000 <span class="stat-percentage">(30%)</span></p>
                                  </div>
                                  <div class="tuition-stat">
                                      <h4>Vencidas</h4>
                                      <p class="stat-value">AOA 125,000 <span class="stat-percentage">(10%)</span></p>
                                  </div>
                              </div>
                              
                              <div class="tuition-filters">
                                  <div class="filter-group">
                                      <label>Turma:</label>
                                      <select>
                                          <option value="all">Todas as Turmas</option>
                                          <option value="1A">1º Ano A</option>
                                          <option value="1B">1º Ano B</option>
                                          <option value="2A">2º Ano A</option>
                                          <option value="2B">2º Ano B</option>
                                      </select>
                                  </div>
                                  <div class="filter-group">
                                      <label>Status:</label>
                                      <select>
                                          <option value="all">Todos</option>
                                          <option value="paid">Pago</option>
                                          <option value="pending">Pendente</option>
                                          <option value="overdue">Vencido</option>
                                      </select>
                                  </div>
                                  <div class="filter-group">
                                      <label>Mês:</label>
                                      <select>
                                          <option value="5">Maio 2023</option>
                                          <option value="4">Abril 2023</option>
                                          <option value="3">Março 2023</option>
                                          <option value="2">Fevereiro 2023</option>
                                          <option value="1">Janeiro 2023</option>
                                      </select>
                                  </div>
                                  <button class="btn-apply-filters"><i class="fas fa-filter"></i> Aplicar</button>
                              </div>
                              
                              <div class="tuition-table">
                                  <table>
                                      <thead>
                                          <tr>
                                              <th>ID</th>
                                              <th>Aluno</th>
                                              <th>Turma</th>
                                              <th>Mês</th>
                                              <th>Valor</th>
                                              <th>Vencimento</th>
                                              <th>Status</th>
                                              <th>Ações</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>#INV001</td>
                                              <td>João Silva</td>
                                              <td>1º Ano A</td>
                                              <td>Maio 2023</td>
                                              <td>AOA 25,000</td>
                                              <td>10/05/2023</td>
                                              <td><span class="status-badge completed">Pago</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                                  <button class="action-btn" title="Enviar"><i class="fas fa-envelope"></i></button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>#INV002</td>
                                              <td>Maria Oliveira</td>
                                              <td>2º Ano B</td>
                                              <td>Maio 2023</td>
                                              <td>AOA 25,000</td>
                                              <td>10/05/2023</td>
                                              <td><span class="status-badge completed">Pago</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                                  <button class="action-btn" title="Enviar"><i class="fas fa-envelope"></i></button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>#INV003</td>
                                              <td>Carlos Santos</td>
                                              <td>3º Ano A</td>
                                              <td>Maio 2023</td>
                                              <td>AOA 25,000</td>
                                              <td>10/05/2023</td>
                                              <td><span class="status-badge pending">Pendente</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                                  <button class="action-btn" title="Enviar"><i class="fas fa-envelope"></i></button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>#INV004</td>
                                              <td>Ana Silva</td>
                                              <td>1º Ano B</td>
                                              <td>Maio 2023</td>
                                              <td>AOA 25,000</td>
                                              <td>10/05/2023</td>
                                              <td><span class="status-badge pending">Pendente</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                                  <button class="action-btn" title="Enviar"><i class="fas fa-envelope"></i></button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>#INV005</td>
                                              <td>Pedro Mendes</td>
                                              <td>2º Ano A</td>
                                              <td>Maio 2023</td>
                                              <td>AOA 25,000</td>
                                              <td>10/05/2023</td>
                                              <td><span class="status-badge overdue">Vencido</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                                  <button class="action-btn" title="Enviar"><i class="fas fa-envelope"></i></button>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                              
                              <div class="pagination">
                                  <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                                  <button class="page-btn active">1</button>
                                  <button class="page-btn">2</button>
                                  <button class="page-btn">3</button>
                                  <span class="page-ellipsis">...</span>
                                  <button class="page-btn">10</button>
                                  <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                              </div>
                          </div>
                          
                          <div class="tab-panel" id="payroll-panel">
                              <div class="panel-header">
                                  <h3>Folha de Pagamento</h3>
                                  <div class="panel-actions">
                                      <button class="btn-process-payroll"><i class="fas fa-money-check-alt"></i> Processar Pagamentos</button>
                                      <button class="btn-export-payroll"><i class="fas fa-file-export"></i> Exportar Relatório</button>
                                  </div>
                              </div>
                              
                              <div class="payroll-summary">
                                  <div class="payroll-stat">
                                      <h4>Total da Folha</h4>
                                      <p class="stat-value">AOA 750,000</p>
                                  </div>
                                  <div class="payroll-stat">
                                      <h4>Professores</h4>
                                      <p class="stat-value">AOA 500,000 <span class="stat-percentage">(66.7%)</span></p>
                                  </div>
                                  <div class="payroll-stat">
                                      <h4>Administrativo</h4>
                                      <p class="stat-value">AOA 150,000 <span class="stat-percentage">(20%)</span></p>
                                  </div>
                                  <div class="payroll-stat">
                                      <h4>Outros</h4>
                                      <p class="stat-value">AOA 100,000 <span class="stat-percentage">(13.3%)</span></p>
                                  </div>
                              </div>
                              
                              <div class="payroll-filters">
                                  <div class="filter-group">
                                      <label>Departamento:</label>
                                      <select>
                                          <option value="all">Todos</option>
                                          <option value="teaching">Professores</option>
                                          <option value="admin">Administrativo</option>
                                          <option value="support">Suporte</option>
                                      </select>
                                  </div>
                                  <div class="filter-group">
                                      <label>Mês:</label>
                                      <select>
                                          <option value="5">Maio 2023</option>
                                          <option value="4">Abril 2023</option>
                                          <option value="3">Março 2023</option>
                                      </select>
                                  </div>
                                  <button class="btn-apply-filters"><i class="fas fa-filter"></i> Aplicar</button>
                              </div>
                              
                              <div class="payroll-table">
                                  <table>
                                      <thead>
                                          <tr>
                                              <th>ID</th>
                                              <th>Funcionário</th>
                                              <th>Cargo</th>
                                              <th>Departamento</th>
                                              <th>Salário Base</th>
                                              <th>Bônus</th>
                                              <th>Deduções</th>
                                              <th>Total</th>
                                              <th>Status</th>
                                              <th>Ações</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>#EMP001</td>
                                              <td>Carlos Ferreira</td>
                                              <td>Professor</td>
                                              <td>Matemática</td>
                                              <td>AOA 80,000</td>
                                              <td>AOA 5,000</td>
                                              <td>AOA 10,000</td>
                                              <td>AOA 75,000</td>
                                              <td><span class="status-badge completed">Pago</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>#EMP002</td>
                                              <td>Maria Santos</td>
                                              <td>Professora</td>
                                              <td>Português</td>
                                              <td>AOA 80,000</td>
                                              <td>AOA 5,000</td>
                                              <td>AOA 10,000</td>
                                              <td>AOA 75,000</td>
                                              <td><span class="status-badge completed">Pago</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>#EMP003</td>
                                              <td>João Oliveira</td>
                                              <td>Coordenador</td>
                                              <td>Administrativo</td>
                                              <td>AOA 100,000</td>
                                              <td>AOA 10,000</td>
                                              <td>AOA 15,000</td>
                                              <td>AOA 95,000</td>
                                              <td><span class="status-badge completed">Pago</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>#EMP004</td>
                                              <td>Ana Costa</td>
                                              <td>Secretária</td>
                                              <td>Administrativo</td>
                                              <td>AOA 60,000</td>
                                              <td>AOA 2,000</td>
                                              <td>AOA 7,000</td>
                                              <td>AOA 55,000</td>
                                              <td><span class="status-badge pending">Pendente</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>#EMP005</td>
                                              <td>Pedro Silva</td>
                                              <td>Zelador</td>
                                              <td>Suporte</td>
                                              <td>AOA 45,000</td>
                                              <td>AOA 1,000</td>
                                              <td>AOA 5,000</td>
                                              <td>AOA 41,000</td>
                                              <td><span class="status-badge completed">Pago</span></td>
                                              <td class="actions">
                                                  <button class="action-btn" title="Ver detalhes"><i class="fas fa-eye"></i></button>
                                                  <button class="action-btn" title="Imprimir"><i class="fas fa-print"></i></button>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                          
                          <div class="tab-panel" id="budget-panel">
                              <div class="panel-header">
                                  <h3>Orçamento Anual</h3>
                                  <div class="panel-actions">
                                      <button class="btn-edit-budget"><i class="fas fa-edit"></i> Editar Orçamento</button>
                                      <button class="btn-export-budget"><i class="fas fa-file-export"></i> Exportar</button>
                                  </div>
                              </div>
                              
                              <div class="budget-progress">
                                  <div class="budget-category">
                                      <div class="category-header">
                                          <h4>Salários</h4>
                                          <div class="budget-values">
                                              <span class="spent">AOA 3,500,000</span>
                                              <span class="separator">/</span>
                                              <span class="total">AOA 9,000,000</span>
                                          </div>
                                      </div>
                                      <div class="progress-bar">
                                          <div class="progress" style="width: 39%;"></div>
                                      </div>
                                      <div class="budget-meta">
                                          <span class="percentage">39% utilizado</span>
                                          <span class="status good">Dentro do orçamento</span>
                                      </div>
                                  </div>
                                  
                                  <div class="budget-category">
                                      <div class="category-header">
                                          <h4>Materiais Didáticos</h4>
                                          <div class="budget-values">
                                              <span class="spent">AOA 850,000</span>
                                              <span class="separator">/</span>
                                              <span class="total">AOA 1,500,000</span>
                                          </div>
                                      </div>
                                      <div class="progress-bar">
                                          <div class="progress" style="width: 57%;"></div>
                                      </div>
                                      <div class="budget-meta">
                                          <span class="percentage">57% utilizado</span>
                                          <span class="status warning">Atenção</span>
                                      </div>
                                  </div>
                                  
                                  <div class="budget-category">
                                      <div class="category-header">
                                          <h4>Infraestrutura</h4>
                                          <div class="budget-values">
                                              <span class="spent">AOA 1,200,000</span>
                                              <span class="separator">/</span>
                                              <span class="total">AOA 2,000,000</span>
                                          </div>
                                      </div>
                                      <div class="progress-bar">
                                          <div class="progress" style="width: 60%;"></div>
                                      </div>
                                      <div class="budget-meta">
                                          <span class="percentage">60% utilizado</span>
                                          <span class="status warning">Atenção</span>
                                      </div>
                                  </div>
                                  
                                  <div class="budget-category">
                                      <div class="category-header">
                                          <h4>Serviços</h4>
                                          <div class="budget-values">
                                              <span class="spent">AOA 450,000</span>
                                              <span class="separator">/</span>
                                              <span class="total">AOA 800,000</span>
                                          </div>
                                      </div>
                                      <div class="progress-bar">
                                          <div class="progress" style="width: 56%;"></div>
                                      </div>
                                      <div class="budget-meta">
                                          <span class="percentage">56% utilizado</span>
                                          <span class="status good">Dentro do orçamento</span>
                                      </div>
                                  </div>
                                  
                                  <div class="budget-category">
                                      <div class="category-header">
                                          <h4>Eventos Escolares</h4>
                                          <div class="budget-values">
                                              <span class="spent">AOA 350,000</span>
                                              <span class="separator">/</span>
                                              <span class="total">AOA 500,000</span>
                                          </div>
                                      </div>
                                      <div class="progress-bar">
                                          <div class="progress" style="width: 70%;"></div>
                                      </div>
                                      <div class="budget-meta">
                                          <span class="percentage">70% utilizado</span>
                                          <span class="status danger">Crítico</span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  
                  <!-- Modal para nova transação -->
                  <div class="transaction-modal" id="transactionModal">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h3>Nova Transação</h3>
                              <button class="close-modal"><i class="fas fa-times"></i></button>
                          </div>
                          <div class="modal-body">
                              <form id="transactionForm">
                                  <div class="form-group">
                                      <label for="transactionType">Tipo:</label>
                                      <select id="transactionType">
                                          <option value="income">Receita</option>
                                          <option value="expense">Despesa</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="transactionDate">Data:</label>
                                      <input type="date" id="transactionDate" value="<?php echo date('Y-m-d'); ?>">
                                  </div>
                                  <div class="form-group">
                                      <label for="transactionDescription">Descrição:</label>
                                      <input type="text" id="transactionDescription" placeholder="Descrição da transação">
                                  </div>
                                  <div class="form-group">
                                      <label for="transactionCategory">Categoria:</label>
                                      <select id="transactionCategory">
                                          <option value="tuition">Mensalidades</option>
                                          <option value="salary">Salários</option>
                                          <option value="materials">Materiais</option>
                                          <option value="infrastructure">Infraestrutura</option>
                                          <option value="services">Serviços</option>
                                          <option value="other">Outros</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="transactionAmount">Valor (AOA):</label>
                                      <input type="number" id="transactionAmount" placeholder="0.00" min="0" step="0.01">
                                  </div>
                                  <div class="form-group">
                                      <label for="transactionNotes">Observações:</label>
                                      <textarea id="transactionNotes" rows="3" placeholder="Observações adicionais"></textarea>
                                  </div>
                                  <div class="form-actions">
                                      <button type="submit" class="btn-save-transaction"><i class="fas fa-save"></i> Salvar</button>
                                      <button type="button" class="btn-cancel"><i class="fas fa-times"></i> Cancelar</button>
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
  <script src="js/finances.js"></script>
</body>
</html>

<?php } else {
    header("Location: ../login.php");
    exit;
} ?>
