document.addEventListener("DOMContentLoaded", () => {
  // Adicione estas variáveis no início do bloco DOMContentLoaded
  const ITEMS_PER_PAGE = 5 // Número de itens por página
  let currentPage = 1 // Página atual
  let totalPages = 1 // Total de páginas
  let allStudents = [] // Array para armazenar todos os estudantes
  let allAttendanceRecords = [] // Array para armazenar todos os registros de presença
  let currentStudentId = null // ID do estudante atualmente selecionado para edição ou visualização
  let currentAttendanceId = null // ID do registro de presença atualmente selecionado

  // Add sidebar toggle button to all pages
  const sidebar = document.querySelector(".sidebar")
  const sidebarToggle = document.createElement("div")
  sidebarToggle.classList.add("sidebar-toggle")
  sidebarToggle.innerHTML = '<i class="fas fa-chevron-left"></i>'
  sidebar.appendChild(sidebarToggle)

  // Check if sidebar state is saved in localStorage
  const sidebarState = localStorage.getItem("sidebarState")
  if (sidebarState === "collapsed") {
    sidebar.classList.add("collapsed")
  }

  // Toggle sidebar on click
  sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed")

    // Save state to localStorage
    if (sidebar.classList.contains("collapsed")) {
      localStorage.setItem("sidebarState", "collapsed")
    } else {
      localStorage.setItem("sidebarState", "expanded")
    }
  })

  // Toggle submenu
  const menuItems = document.querySelectorAll(".has-submenu .menu-item")
  menuItems.forEach((item) => {
    item.addEventListener("click", function () {
      const parent = this.parentElement
      const submenu = this.nextElementSibling

      // Toggle active class
      parent.classList.toggle("active")

      // Toggle submenu visibility
      if (submenu.classList.contains("show")) {
        submenu.classList.remove("show")
      } else {
        submenu.classList.add("show")
      }
    })
  })

  // Modal functionality
  const addStudentBtn = document.getElementById("add-student-btn")
  const addTeacherBtn = document.getElementById("add-teacher-btn")
  const markAttendanceBtn = document.getElementById("mark-attendance-btn")
  const studentModal = document.getElementById("student-modal")
  const teacherModal = document.getElementById("teacher-modal")
  const closeModalBtns = document.querySelectorAll(".close-modal")
  const cancelBtns = document.querySelectorAll(".cancel-btn")

  // Open student modal
  if (addStudentBtn) {
    addStudentBtn.addEventListener("click", () => {
      // Resetar o ID do estudante atual (estamos adicionando um novo)
      currentStudentId = null

      // Atualizar o título do modal
      document.getElementById("student-modal-title").textContent = "Adicionar Novo Aluno"

      studentModal.style.display = "block"
      // Reset form when opening
      document.getElementById("student-form").reset()
      // Clear any error messages
      clearAllErrorMessages()
      // Clear file previews
      document.getElementById("bi-front-preview").innerHTML = ""
      document.getElementById("bi-back-preview").innerHTML = ""
    })
  }

  // Open teacher modal
  if (addTeacherBtn) {
    addTeacherBtn.addEventListener("click", () => {
      teacherModal.style.display = "block"
    })
  }

  // Open mark attendance modal
  if (markAttendanceBtn) {
    markAttendanceBtn.addEventListener("click", () => {
      // Criar o modal de marcar presença se não existir
      if (!document.getElementById("mark-attendance-modal")) {
        createMarkAttendanceModal()
      }

      // Preencher o modal com os estudantes da turma selecionada
      populateMarkAttendanceModal()

      // Mostrar o modal
      document.getElementById("mark-attendance-modal").style.display = "block"
    })
  }

  // Close modals with X button
  closeModalBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      const modal = this.closest(".modal")
      modal.style.display = "none"
    })
  })

  // Close modals with Cancel button
  cancelBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      const modal = this.closest(".modal")
      modal.style.display = "none"

      // If it's the student form, reset it
      if (modal.id === "student-modal") {
        document.getElementById("student-form").reset()
        clearAllErrorMessages()
        document.getElementById("bi-front-preview").innerHTML = ""
        document.getElementById("bi-back-preview").innerHTML = ""
      }
    })
  })

  // Specific cancel button for student form
  const cancelStudentBtn = document.getElementById("cancel-student-btn")
  if (cancelStudentBtn) {
    cancelStudentBtn.addEventListener("click", () => {
      studentModal.style.display = "none"
      document.getElementById("student-form").reset()
      clearAllErrorMessages()
      document.getElementById("bi-front-preview").innerHTML = ""
      document.getElementById("bi-back-preview").innerHTML = ""
    })
  }

  // Close modals when clicking outside
  window.addEventListener("click", (event) => {
    if (event.target.classList.contains("modal")) {
      event.target.style.display = "none"
    }
  })

  // Função para limpar todas as mensagens de erro
  function clearAllErrorMessages() {
    const errorMessages = document.querySelectorAll(".error-message")
    errorMessages.forEach((msg) => msg.remove())

    const errorInputs = document.querySelectorAll(".input-error")
    errorInputs.forEach((input) => input.classList.remove("input-error"))
  }

  // Função para validar o formato do BI
  function validateBI(biNumber) {
    // Padrão: 7 números + 2 letras + 3 números
    const biPattern = /^\d{7}[A-Z]{2}\d{3}$/
    return biPattern.test(biNumber)
  }

  // Função para validar a complexidade da senha
  function validatePassword(password) {
    // Deve conter pelo menos:
    // - 8 caracteres
    // - Uma letra maiúscula
    // - Uma letra minúscula
    // - Um número
    // - Um caractere especial
    const minLength = password.length >= 8
    const hasUpperCase = /[A-Z]/.test(password)
    const hasLowerCase = /[a-z]/.test(password)
    const hasNumber = /\d/.test(password)
    const hasSpecialChar = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(password)

    return {
      isValid: minLength && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar,
      errors: {
        minLength,
        hasUpperCase,
        hasLowerCase,
        hasNumber,
        hasSpecialChar,
      },
    }
  }

  // Validação do campo BI
  const biNumberInput = document.getElementById("bi-number")
  if (biNumberInput) {
    biNumberInput.addEventListener("input", function () {
      const biNumber = this.value.trim()
      const isValid = validateBI(biNumber)

      // Remove mensagem de erro anterior se existir
      removeErrorMessage(this)

      if (biNumber && !isValid) {
        showErrorMessage(this, "O BI deve seguir o formato: 7 números + 2 letras + 3 números (Ex: 0000000LA000)")
      }
    })
  }

  // Validação do campo senha
  const passwordInput = document.getElementById("password")
  if (passwordInput) {
    passwordInput.addEventListener("input", function () {
      const password = this.value
      const validation = validatePassword(password)

      // Remove mensagem de erro anterior se existir
      removeErrorMessage(this)

      if (password && !validation.isValid) {
        let errorMsg = "A senha deve conter:"
        if (!validation.errors.minLength) errorMsg += "<br>- Pelo menos 8 caracteres"
        if (!validation.errors.hasUpperCase) errorMsg += "<br>- Pelo menos uma letra maiúscula"
        if (!validation.errors.hasLowerCase) errorMsg += "<br>- Pelo menos uma letra minúscula"
        if (!validation.errors.hasNumber) errorMsg += "<br>- Pelo menos um número"
        if (!validation.errors.hasSpecialChar) errorMsg += "<br>- Pelo menos um caractere especial (!@#$%^&*...)"

        showErrorMessage(this, errorMsg)
      }
    })
  }

  // Form submission
  const studentForm = document.getElementById("student-form")
  const teacherForm = document.getElementById("teacher-form")

  // Adicione esta função para atualizar a paginação
  function updatePagination() {
    const paginationContainer = document.querySelector(".pagination")
    if (!paginationContainer) return

    // Limpar paginação existente
    paginationContainer.innerHTML = ""

    // Botão anterior
    const prevButton = document.createElement("button")
    prevButton.className = "pagination-btn"
    prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>'
    prevButton.disabled = currentPage === 1
    prevButton.addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--
        renderStudentsTable()
        updatePagination()
      }
    })
    paginationContainer.appendChild(prevButton)

    // Botões de número de página
    const maxPagesToShow = 3
    let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2))
    const endPage = Math.min(totalPages, startPage + maxPagesToShow - 1)

    // Ajustar startPage se necessário
    if (endPage - startPage + 1 < maxPagesToShow) {
      startPage = Math.max(1, endPage - maxPagesToShow + 1)
    }

    for (let i = startPage; i <= endPage; i++) {
      const pageButton = document.createElement("button")
      pageButton.className = "pagination-btn" + (i === currentPage ? " active" : "")
      pageButton.textContent = i
      pageButton.addEventListener("click", () => {
        currentPage = i
        renderStudentsTable()
        updatePagination()
      })
      paginationContainer.appendChild(pageButton)
    }

    // Botão próximo
    const nextButton = document.createElement("button")
    nextButton.className = "pagination-btn"
    nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>'
    nextButton.disabled = currentPage === totalPages
    nextButton.addEventListener("click", () => {
      if (currentPage < totalPages) {
        currentPage++
        renderStudentsTable()
        updatePagination()
      }
    })
    paginationContainer.appendChild(nextButton)
  }

  // Função para atualizar a paginação da tabela de presença
  function updateAttendancePagination() {
    const paginationContainer = document.querySelector(".attendance-pagination")
    if (!paginationContainer) return

    // Limpar paginação existente
    paginationContainer.innerHTML = ""

    // Botão anterior
    const prevButton = document.createElement("button")
    prevButton.className = "pagination-btn"
    prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>'
    prevButton.disabled = currentPage === 1
    prevButton.addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--
        renderAttendanceTable()
        updateAttendancePagination()
      }
    })
    paginationContainer.appendChild(prevButton)

    // Botões de número de página
    const maxPagesToShow = 3
    let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2))
    const endPage = Math.min(totalPages, startPage + maxPagesToShow - 1)

    // Ajustar startPage se necessário
    if (endPage - startPage + 1 < maxPagesToShow) {
      startPage = Math.max(1, endPage - maxPagesToShow + 1)
    }

    for (let i = startPage; i <= endPage; i++) {
      const pageButton = document.createElement("button")
      pageButton.className = "pagination-btn" + (i === currentPage ? " active" : "")
      pageButton.textContent = i
      pageButton.addEventListener("click", () => {
        currentPage = i
        renderAttendanceTable()
        updateAttendancePagination()
      })
      paginationContainer.appendChild(pageButton)
    }

    // Botão próximo
    const nextButton = document.createElement("button")
    nextButton.className = "pagination-btn"
    nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>'
    nextButton.disabled = currentPage === totalPages
    nextButton.addEventListener("click", () => {
      if (currentPage < totalPages) {
        currentPage++
        renderAttendanceTable()
        updateAttendancePagination()
      }
    })
    paginationContainer.appendChild(nextButton)
  }

  // Modifique a função renderStudentsTable() para filtrar por turma

  function renderStudentsTable() {
    const tableBody = document.getElementById("student-table-body")
    if (!tableBody) return

    // Obter o valor do filtro de turma
    const classFilter = document.getElementById("class-filter")?.value || ""
    const searchQuery = document.getElementById("student-search")?.value?.toLowerCase() || ""

    // Filtrar os estudantes
    let filteredStudents = allStudents

    // Aplicar filtro de turma
    if (classFilter) {
      filteredStudents = filteredStudents.filter((student) => student.class === classFilter)
    }

    // Aplicar filtro de pesquisa
    if (searchQuery) {
      filteredStudents = filteredStudents.filter(
        (student) => student.name.toLowerCase().includes(searchQuery) || student.id.toLowerCase().includes(searchQuery),
      )
    }

    // Limpar tabela
    tableBody.innerHTML = ""

    // Verificar se há estudantes após a filtragem
    if (filteredStudents.length === 0) {
      const emptyRow = document.createElement("tr")
      emptyRow.innerHTML = `
      <td colspan="7" class="text-center py-4">Nenhum estudante encontrado para os filtros selecionados.</td>
    `
      tableBody.appendChild(emptyRow)

      // Atualizar paginação
      totalPages = 1
      currentPage = 1
      updatePagination()
      return
    }

    // Calcular o número total de páginas
    totalPages = Math.ceil(filteredStudents.length / ITEMS_PER_PAGE)

    // Ajustar a página atual se necessário
    if (currentPage > totalPages) {
      currentPage = totalPages
    }

    // Calcular índices de início e fim para a página atual
    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE
    const endIndex = Math.min(startIndex + ITEMS_PER_PAGE, filteredStudents.length)

    // Renderizar apenas os estudantes da página atual
    for (let i = startIndex; i < endIndex; i++) {
      const student = filteredStudents[i]
      const newRow = document.createElement("tr")
      newRow.innerHTML = `
      <td>${student.id}</td>
      <td class="font-medium">${student.name}</td>
      <td>${student.class}</td>
      <td>${student.gender}</td>
      <td>${student.contact}</td>
      <td>
        <span class="status-badge bg-green-50 text-green-700 hover:bg-green-50">
          ${student.attendance}
        </span>
      </td>
      <td>
        <div class="flex gap-2">
          <button class="action-btn edit" title="Editar" data-id="${student.id}"><i class="fas fa-edit"></i></button>
          <button class="action-btn view" title="Ver" data-id="${student.id}"><i class="fas fa-eye"></i></button>
          <button class="action-btn delete" title="Eliminar" data-id="${student.id}"><i class="fas fa-trash"></i></button>
        </div>
      </td>
    `

      tableBody.appendChild(newRow)
    }

    // Adicionar event listeners para os botões de ação
    addActionButtonListeners()
  }

  // Função para renderizar a tabela de presença com paginação e filtros
  function renderAttendanceTable() {
    const tableBody = document.getElementById("attendance-table-body")
    if (!tableBody) return

    // Obter os valores dos filtros
    const classFilter = document.getElementById("attendance-class-filter")?.value || ""
    const dateFilter = document.getElementById("attendance-date")?.value || ""
    const searchQuery = document.getElementById("attendance-search")?.value?.toLowerCase() || ""

    // Converter a data do formato yyyy-mm-dd para dd/mm/yyyy para comparação
    const formattedDateFilter = dateFilter ? formatDate(dateFilter) : ""

    // Filtrar os registros de presença
    let filteredRecords = allAttendanceRecords

    // Aplicar filtro de turma
    if (classFilter) {
      filteredRecords = filteredRecords.filter((record) => record.class === classFilter)
    }

    // Aplicar filtro de data
    if (formattedDateFilter) {
      filteredRecords = filteredRecords.filter((record) => record.date === formattedDateFilter)
    }

    // Aplicar filtro de pesquisa
    if (searchQuery) {
      filteredRecords = filteredRecords.filter(
        (record) => record.name.toLowerCase().includes(searchQuery) || record.id.toLowerCase().includes(searchQuery),
      )
    }

    // Limpar tabela
    tableBody.innerHTML = ""

    // Verificar se há registros após a filtragem
    if (filteredRecords.length === 0) {
      const emptyRow = document.createElement("tr")
      emptyRow.innerHTML = `
        <td colspan="7" class="text-center py-4">Nenhum registro encontrado para os filtros selecionados.</td>
      `
      tableBody.appendChild(emptyRow)

      // Atualizar paginação
      totalPages = 1
      currentPage = 1
      updateAttendancePagination()
      return
    }

    // Calcular o número total de páginas
    totalPages = Math.ceil(filteredRecords.length / ITEMS_PER_PAGE)

    // Ajustar a página atual se necessário
    if (currentPage > totalPages) {
      currentPage = totalPages
    }

    // Calcular índices de início e fim para a página atual
    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE
    const endIndex = Math.min(startIndex + ITEMS_PER_PAGE, filteredRecords.length)

    // Renderizar apenas os registros da página atual
    for (let i = startIndex; i < endIndex; i++) {
      const record = filteredRecords[i]
      const newRow = document.createElement("tr")
      newRow.innerHTML = `
        <td>${record.id}</td>
        <td class="font-medium">${record.name}</td>
        <td>${record.class}</td>
        <td>${record.date}</td>
        <td>${record.time || "-"}</td>
        <td><span class="status-badge ${getStatusClass(record.status)}">${getStatusText(record.status)}</span></td>
        <td>${record.notes || "-"}</td>
        <td>
          <div class="flex gap-2">
            <button class="action-btn edit-attendance" title="Editar" data-id="${record.id}"><i class="fas fa-edit"></i></button>
            <button class="action-btn view-attendance" title="Ver" data-id="${record.id}"><i class="fas fa-eye"></i></button>
          </div>
        </td>
      `

      tableBody.appendChild(newRow)
    }

    // Adicionar event listeners para os botões de ação
    addAttendanceActionButtonListeners()
  }

  // Função para obter a classe CSS com base no status
  function getStatusClass(status) {
    switch (status) {
      case "present":
        return "present"
      case "absent":
        return "absent"
      case "late":
        return "late"
      default:
        return ""
    }
  }

  // Função para obter o texto do status
  function getStatusText(status) {
    switch (status) {
      case "present":
        return "Presente"
      case "absent":
        return "Ausente"
      case "late":
        return "Atrasado"
      default:
        return "Desconhecido"
    }
  }

  // Função para formatar a data de yyyy-mm-dd para dd/mm/yyyy
  function formatDate(dateString) {
    if (!dateString) return ""

    const parts = dateString.split("-")
    if (parts.length !== 3) return dateString

    return `${parts[2]}/${parts[1]}/${parts[0]}`
  }

  // Função para formatar a data de dd/mm/yyyy para yyyy-mm-dd
  function formatDateForInput(dateString) {
    if (!dateString) return ""

    const parts = dateString.split("/")
    if (parts.length !== 3) return dateString

    return `${parts[2]}-${parts[1]}-${parts[0]}`
  }

  // Função para adicionar event listeners aos botões de ação
  function addActionButtonListeners() {
    // Botões de editar
    document.querySelectorAll(".action-btn.edit").forEach((button) => {
      button.addEventListener("click", function () {
        const studentId = this.getAttribute("data-id")
        editStudent(studentId)
      })
    })

    // Botões de visualizar
    document.querySelectorAll(".action-btn.view").forEach((button) => {
      button.addEventListener("click", function () {
        const studentId = this.getAttribute("data-id")
        viewStudent(studentId)
      })
    })

    // Botões de deletar
    document.querySelectorAll(".action-btn.delete").forEach((button) => {
      button.addEventListener("click", function () {
        const studentId = this.getAttribute("data-id")
        deleteStudent(studentId)
      })
    })
  }

  // Função para adicionar event listeners aos botões de ação da tabela de presença
  function addAttendanceActionButtonListeners() {
    // Botões de editar presença
    document.querySelectorAll(".action-btn.edit-attendance").forEach((button) => {
      button.addEventListener("click", function () {
        const attendanceId = this.getAttribute("data-id")
        editAttendance(attendanceId)
      })
    })

    // Botões de visualizar presença
    document.querySelectorAll(".action-btn.view-attendance").forEach((button) => {
      button.addEventListener("click", function () {
        const attendanceId = this.getAttribute("data-id")
        viewAttendance(attendanceId)
      })
    })
  }

  // Função para editar um estudante
  function editStudent(studentId) {
    // Encontrar o estudante pelo ID
    const student = allStudents.find((s) => s.id === studentId)
    if (!student) return

    // Salvar o ID do estudante atual
    currentStudentId = studentId

    // Atualizar o título do modal
    document.getElementById("student-modal-title").textContent = "Editar Aluno"

    // Preencher o formulário com os dados do estudante
    document.getElementById("student-name").value = student.name

    // Selecionar a turma
    const classSelect = document.getElementById("student-class")
    if (classSelect) {
      for (let i = 0; i < classSelect.options.length; i++) {
        if (classSelect.options[i].value === student.class) {
          classSelect.selectedIndex = i
          break
        }
      }
    }

    // Selecionar o gênero
    const genderSelect = document.getElementById("student-gender")
    if (genderSelect) {
      for (let i = 0; i < genderSelect.options.length; i++) {
        if (genderSelect.options[i].value === student.gender) {
          genderSelect.selectedIndex = i
          break
        }
      }
    }

    // Preencher outros campos se existirem
    // Nota: Alguns campos como BI, data de nascimento, etc. não estão no objeto student
    // Esses campos seriam preenchidos se tivéssemos esses dados

    // Separar o código do país e o número de telefone
    if (student.contact) {
      const contactParts = student.contact.split(" ")
      if (contactParts.length > 1) {
        const countryCode = contactParts[0]
        const phoneNumber = contactParts.slice(1).join(" ")

        // Selecionar o código do país
        const countryCodeSelect = document.getElementById("country-code")
        if (countryCodeSelect) {
          for (let i = 0; i < countryCodeSelect.options.length; i++) {
            if (countryCodeSelect.options[i].value === countryCode) {
              countryCodeSelect.selectedIndex = i
              break
            }
          }
        }

        // Preencher o número de telefone
        const contactInput = document.getElementById("student-contact")
        if (contactInput) {
          contactInput.value = phoneNumber
        }
      }
    }

    // Abrir o modal
    studentModal.style.display = "block"
  }

  // Função para visualizar um estudante
  function viewStudent(studentId) {
    // Encontrar o estudante pelo ID
    const student = allStudents.find((s) => s.id === studentId)
    if (!student) return

    // Criar o modal de visualização se não existir
    if (!document.getElementById("view-student-modal")) {
      createViewStudentModal()
    }

    // Preencher os dados do estudante no modal
    document.getElementById("view-student-id").textContent = student.id
    document.getElementById("view-student-name").textContent = student.name
    document.getElementById("view-student-class").textContent = student.class
    document.getElementById("view-student-gender").textContent = student.gender
    document.getElementById("view-student-contact").textContent = student.contact
    document.getElementById("view-student-attendance").textContent = student.attendance

    // Mostrar o modal
    document.getElementById("view-student-modal").style.display = "block"
  }

  // Função para criar o modal de visualização de estudante
  function createViewStudentModal() {
    const modal = document.createElement("div")
    modal.id = "view-student-modal"
    modal.className = "modal"

    modal.innerHTML = `
      <div class="modal-content">
        <div class="modal-header">
          <h3>Detalhes do Aluno</h3>
          <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
          <div class="student-details">
            <div class="detail-row">
              <div class="detail-label">ID:</div>
              <div class="detail-value" id="view-student-id"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Nome:</div>
              <div class="detail-value" id="view-student-name"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Turma:</div>
              <div class="detail-value" id="view-student-class"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Gênero:</div>
              <div class="detail-value" id="view-student-gender"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Contato:</div>
              <div class="detail-value" id="view-student-contact"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Presença:</div>
              <div class="detail-value" id="view-student-attendance"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="close-btn">Fechar</button>
        </div>
      </div>
    `

    document.body.appendChild(modal)

    // Adicionar event listener para fechar o modal
    modal.querySelector(".close-modal").addEventListener("click", () => {
      modal.style.display = "none"
    })

    modal.querySelector(".close-btn").addEventListener("click", () => {
      modal.style.display = "none"
    })

    // Fechar o modal ao clicar fora dele
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.style.display = "none"
      }
    })
  }

  // Função para editar um registro de presença
  function editAttendance(attendanceId) {
    // Encontrar o registro pelo ID
    const record = allAttendanceRecords.find((r) => r.id === attendanceId)
    if (!record) return

    // Salvar o ID do registro atual
    currentAttendanceId = attendanceId

    // Criar o modal de edição se não existir
    if (!document.getElementById("edit-attendance-modal")) {
      createEditAttendanceModal()
    }

    // Preencher o formulário com os dados do registro
    document.getElementById("edit-attendance-student-name").textContent = record.name
    document.getElementById("edit-attendance-student-id").textContent = record.id
    document.getElementById("edit-attendance-class").textContent = record.class
    document.getElementById("edit-attendance-date").textContent = record.date

    // Selecionar o status
    const statusSelect = document.getElementById("edit-attendance-status")
    for (let i = 0; i < statusSelect.options.length; i++) {
      if (statusSelect.options[i].value === record.status) {
        statusSelect.selectedIndex = i
        break
      }
    }

    // Preencher as notas
    document.getElementById("edit-attendance-notes").value = record.notes || ""

    // Mostrar o modal
    document.getElementById("edit-attendance-modal").style.display = "block"
  }

  // Função para criar o modal de edição de presença
  function createEditAttendanceModal() {
    const modal = document.createElement("div")
    modal.id = "edit-attendance-modal"
    modal.className = "modal"

    modal.innerHTML = `
      <div class="modal-content">
        <div class="modal-header">
          <h3>Editar Registro de Presença</h3>
          <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
          <div class="student-details mb-4">
            <div class="detail-row">
              <div class="detail-label">Aluno:</div>
              <div class="detail-value" id="edit-attendance-student-name"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">ID:</div>
              <div class="detail-value" id="edit-attendance-student-id"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Turma:</div>
              <div class="detail-value" id="edit-attendance-class"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Data:</div>
              <div class="detail-value" id="edit-attendance-date"></div>
            </div>
          </div>
          
          <form id="edit-attendance-form">
            <div class="form-group">
              <label for="edit-attendance-status">Estado</label>
              <select id="edit-attendance-status" required>
                <option value="present">Presente</option>
                <option value="absent">Ausente</option>
                <option value="late">Atrasado</option>
              </select>
            </div>
            <div class="form-group">
              <label for="edit-attendance-notes">Observações</label>
              <textarea id="edit-attendance-notes" rows="3"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn">Cancelar</button>
          <button class="save-btn" id="save-attendance-btn">Salvar</button>
        </div>
      </div>
    `

    document.body.appendChild(modal)

    // Adicionar event listener para fechar o modal
    modal.querySelector(".close-modal").addEventListener("click", () => {
      modal.style.display = "none"
    })

    modal.querySelector(".cancel-btn").addEventListener("click", () => {
      modal.style.display = "none"
    })

    // Adicionar event listener para salvar as alterações
    modal.querySelector("#save-attendance-btn").addEventListener("click", () => {
      saveAttendanceChanges()
    })

    // Fechar o modal ao clicar fora dele
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.style.display = "none"
      }
    })
  }

  // Função para salvar as alterações no registro de presença
  function saveAttendanceChanges() {
    if (!currentAttendanceId) return

    // Encontrar o índice do registro no array
    const recordIndex = allAttendanceRecords.findIndex((r) => r.id === currentAttendanceId)
    if (recordIndex === -1) return

    // Obter os valores do formulário
    const status = document.getElementById("edit-attendance-status").value
    const notes = document.getElementById("edit-attendance-notes").value

    // Atualizar o registro
    allAttendanceRecords[recordIndex].status = status
    allAttendanceRecords[recordIndex].notes = notes

    // Fechar o modal
    document.getElementById("edit-attendance-modal").style.display = "none"

    // Renderizar a tabela novamente
    renderAttendanceTable()

    // Mostrar mensagem de sucesso
    alert("Registro de presença atualizado com sucesso!")
  }

  // Função para visualizar um registro de presença
  function viewAttendance(attendanceId) {
    // Encontrar o registro pelo ID
    const record = allAttendanceRecords.find((r) => r.id === attendanceId)
    if (!record) return

    // Criar o modal de visualização se não existir
    if (!document.getElementById("view-attendance-modal")) {
      createViewAttendanceModal()
    }

    // Preencher os dados do registro no modal
    document.getElementById("view-attendance-id").textContent = record.id
    document.getElementById("view-attendance-name").textContent = record.name
    document.getElementById("view-attendance-class").textContent = record.class
    document.getElementById("view-attendance-date").textContent = record.date
    document.getElementById("view-attendance-time").textContent = record.time || "-"
    document.getElementById("view-attendance-status").innerHTML =
      `<span class="status-badge ${getStatusClass(record.status)}">${getStatusText(record.status)}</span>`
    document.getElementById("view-attendance-notes").textContent = record.notes || "-"

    // Mostrar o modal
    document.getElementById("view-attendance-modal").style.display = "block"
  }

  // Função para criar o modal de visualização de presença
  function createViewAttendanceModal() {
    const modal = document.createElement("div")
    modal.id = "view-attendance-modal"
    modal.className = "modal"

    modal.innerHTML = `
      <div class="modal-content">
        <div class="modal-header">
          <h3>Detalhes do Registro de Presença</h3>
          <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
          <div class="student-details">
            <div class="detail-row">
              <div class="detail-label">ID:</div>
              <div class="detail-value" id="view-attendance-id"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Aluno:</div>
              <div class="detail-value" id="view-attendance-name"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Turma:</div>
              <div class="detail-value" id="view-attendance-class"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Data:</div>
              <div class="detail-value" id="view-attendance-date"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Hora:</div>
              <div class="detail-value" id="view-attendance-time"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Estado:</div>
              <div class="detail-value" id="view-attendance-status"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Observações:</div>
              <div class="detail-value" id="view-attendance-notes"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="close-btn">Fechar</button>
        </div>
      </div>
    `

    document.body.appendChild(modal)

    // Adicionar event listener para fechar o modal
    modal.querySelector(".close-modal").addEventListener("click", () => {
      modal.style.display = "none"
    })

    modal.querySelector(".close-btn").addEventListener("click", () => {
      modal.style.display = "none"
    })

    // Fechar o modal ao clicar fora dele
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.style.display = "none"
      }
    })
  }

  // Função para criar o modal de marcar presença
  function createMarkAttendanceModal() {
    const modal = document.createElement("div")
    modal.id = "mark-attendance-modal"
    modal.className = "modal"

    modal.innerHTML = `
      <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
          <h3>Marcar Presença</h3>
          <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group">
              <label for="mark-attendance-date">Data</label>
              <input type="date" id="mark-attendance-date" required value="${new Date().toISOString().split("T")[0]}">
            </div>
            <div class="form-group">
              <label for="mark-attendance-class">Turma</label>
              <select id="mark-attendance-class" required>
                <option value="">Selecionar Turma</option>
                <option value="Turma 10ª A Informática">Turma 10ª A Informática</option>
                <option value="Turma 10ª B Informática">Turma 10ª B Informática</option>
                <option value="Turma 11ª Informática">Turma 11ª Informática</option>
                <option value="Turma 12ª Informática">Turma 12ª Informática</option>
                <option value="Turma 13ª Informática">Turma 13ª Informática</option>
              </select>
            </div>
          </div>
          
          <div class="attendance-list-container" style="max-height: 400px; overflow-y: auto; margin-top: 20px;">
            <table class="data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome do Aluno</th>
                  <th>Estado</th>
                  <th>Observações</th>
                </tr>
              </thead>
              <tbody id="mark-attendance-list">
                <tr>
                  <td colspan="4" class="text-center py-4">Selecione uma turma para ver os alunos.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn">Cancelar</button>
          <button class="save-btn" id="save-mark-attendance-btn">Salvar Presença</button>
        </div>
      </div>
    `

    document.body.appendChild(modal)

    // Adicionar event listener para fechar o modal
    modal.querySelector(".close-modal").addEventListener("click", () => {
      modal.style.display = "none"
    })

    modal.querySelector(".cancel-btn").addEventListener("click", () => {
      modal.style.display = "none"
    })

    // Adicionar event listener para o seletor de turma
    modal.querySelector("#mark-attendance-class").addEventListener("change", function () {
      populateStudentList(this.value)
    })

    // Adicionar event listener para salvar a presença
    modal.querySelector("#save-mark-attendance-btn").addEventListener("click", () => {
      saveMarkAttendance()
    })

    // Fechar o modal ao clicar fora dele
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.style.display = "none"
      }
    })
  }

  // Função para preencher o modal de marcar presença
  function populateMarkAttendanceModal() {
    // Obter a turma selecionada na tabela de presença
    const classFilter = document.getElementById("attendance-class-filter")
    if (classFilter && classFilter.value) {
      // Selecionar a mesma turma no modal
      const markAttendanceClass = document.getElementById("mark-attendance-class")
      markAttendanceClass.value = classFilter.value

      // Preencher a lista de alunos
      populateStudentList(classFilter.value)
    }
  }

  // Função para preencher a lista de alunos no modal de marcar presença
  function populateStudentList(className) {
    if (!className) return

    // Filtrar os alunos da turma selecionada
    const classStudents = allStudents.filter((student) => student.class === className)

    // Obter a tabela
    const tableBody = document.getElementById("mark-attendance-list")
    if (!tableBody) return

    // Limpar a tabela
    tableBody.innerHTML = ""

    // Verificar se há alunos na turma
    if (classStudents.length === 0) {
      const emptyRow = document.createElement("tr")
      emptyRow.innerHTML = `
        <td colspan="4" class="text-center py-4">Nenhum aluno encontrado nesta turma.</td>
      `
      tableBody.appendChild(emptyRow)
      return
    }

    // Preencher a tabela com os alunos
    classStudents.forEach((student) => {
      const row = document.createElement("tr")
      row.innerHTML = `
        <td>${student.id}</td>
        <td>${student.name}</td>
        <td>
          <select class="attendance-status" data-student-id="${student.id}">
            <option value="present">Presente</option>
            <option value="absent">Ausente</option>
            <option value="late">Atrasado</option>
          </select>
        </td>
        <td>
          <input type="text" class="attendance-notes" data-student-id="${student.id}" placeholder="Observações">
        </td>
      `
      tableBody.appendChild(row)
    })
  }

  // Função para salvar os registros de presença
  function saveMarkAttendance() {
    // Obter a data e a turma
    const dateInput = document.getElementById("mark-attendance-date")
    const classSelect = document.getElementById("mark-attendance-class")

    if (!dateInput || !dateInput.value || !classSelect || !classSelect.value) {
      alert("Por favor, selecione uma data e uma turma.")
      return
    }

    // Formatar a data para dd/mm/yyyy
    const formattedDate = formatDate(dateInput.value)
    const className = classSelect.value

    // Obter todos os status e observações
    const statusSelects = document.querySelectorAll(".attendance-status")
    const notesInputs = document.querySelectorAll(".attendance-notes")

    // Verificar se já existem registros para esta data e turma
    const existingRecords = allAttendanceRecords.filter(
      (record) => record.date === formattedDate && record.class === className,
    )

    if (existingRecords.length > 0) {
      if (!confirm("Já existem registros de presença para esta data e turma. Deseja substituí-los?")) {
        return
      }

      // Remover os registros existentes
      allAttendanceRecords = allAttendanceRecords.filter(
        (record) => !(record.date === formattedDate && record.class === className),
      )
    }

    // Criar novos registros
    const newRecords = []

    statusSelects.forEach((select) => {
      const studentId = select.getAttribute("data-student-id")
      const student = allStudents.find((s) => s.id === studentId)

      if (student) {
        const status = select.value
        const notesInput = document.querySelector(`.attendance-notes[data-student-id="${studentId}"]`)
        const notes = notesInput ? notesInput.value : ""

        // Criar um ID único para o registro
        const recordId = `ATT${Date.now().toString().slice(-6)}${Math.floor(Math.random() * 1000)}`

        // Criar o registro
        const record = {
          id: recordId,
          studentId: studentId,
          name: student.name,
          class: className,
          date: formattedDate,
          time: new Date().toLocaleTimeString("pt-BR", { hour: "2-digit", minute: "2-digit" }),
          status: status,
          notes: notes,
        }

        newRecords.push(record)
      }
    })

    // Adicionar os novos registros ao array
    allAttendanceRecords = [...allAttendanceRecords, ...newRecords]

    // Fechar o modal
    document.getElementById("mark-attendance-modal").style.display = "none"

    // Renderizar a tabela novamente
    renderAttendanceTable()

    // Mostrar mensagem de sucesso
    alert(`Presença marcada com sucesso para ${newRecords.length} alunos.`)
  }

  // Função para deletar um estudante
  function deleteStudent(studentId) {
    // Criar o modal de confirmação se não existir
    if (!document.getElementById("delete-confirmation-modal")) {
      createDeleteConfirmationModal()
    }

    // Salvar o ID do estudante a ser excluído
    currentStudentId = studentId

    // Mostrar o modal de confirmação
    document.getElementById("delete-confirmation-modal").style.display = "block"
  }

  // Função para criar o modal de confirmação de exclusão
  function createDeleteConfirmationModal() {
    const modal = document.createElement("div")
    modal.id = "delete-confirmation-modal"
    modal.className = "modal"

    modal.innerHTML = `
      <div class="modal-content">
        <div class="modal-header">
          <h3>Confirmar Exclusão</h3>
          <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja excluir este aluno? Esta ação não pode ser desfeita.</p>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn">Cancelar</button>
          <button class="delete-confirm-btn danger-btn">Excluir</button>
        </div>
      </div>
    `

    document.body.appendChild(modal)

    // Adicionar event listener para fechar o modal
    modal.querySelector(".close-modal").addEventListener("click", () => {
      modal.style.display = "none"
    })

    modal.querySelector(".cancel-btn").addEventListener("click", () => {
      modal.style.display = "none"
    })

    // Adicionar event listener para confirmar a exclusão
    modal.querySelector(".delete-confirm-btn").addEventListener("click", () => {
      confirmDeleteStudent()
      modal.style.display = "none"
    })

    // Fechar o modal ao clicar fora dele
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.style.display = "none"
      }
    })
  }

  // Função para confirmar a exclusão do estudante
  function confirmDeleteStudent() {
    if (!currentStudentId) return

    // Encontrar o índice do estudante no array
    const studentIndex = allStudents.findIndex((s) => s.id === currentStudentId)
    if (studentIndex === -1) return

    // Remover o estudante do array
    allStudents.splice(studentIndex, 1)

    // Recalcular o número total de páginas
    totalPages = Math.max(1, Math.ceil(allStudents.length / ITEMS_PER_PAGE))

    // Ajustar a página atual se necessário
    if (currentPage > totalPages) {
      currentPage = totalPages
    }

    // Renderizar a tabela e atualizar a paginação
    renderStudentsTable()
    updatePagination()

    // Mostrar mensagem de sucesso
    alert("Aluno excluído com sucesso!")
  }

  // Modifique a função addStudentToTable para adicionar o estudante ao array
  function addStudentToTable(student) {
    // Se estamos editando um estudante existente
    if (currentStudentId) {
      // Encontrar o índice do estudante no array
      const studentIndex = allStudents.findIndex((s) => s.id === currentStudentId)
      if (studentIndex !== -1) {
        // Manter o ID original
        student.id = currentStudentId
        // Atualizar o estudante no array
        allStudents[studentIndex] = student
        // Resetar o ID do estudante atual
        currentStudentId = null
      }
    } else {
      // Adicionar o estudante ao array
      allStudents.unshift(student) // Adiciona no início para mostrar os mais recentes primeiro
    }

    // Recalcular o número total de páginas
    totalPages = Math.ceil(allStudents.length / ITEMS_PER_PAGE)

    // Ir para a primeira página para mostrar o novo estudante
    currentPage = 1

    // Renderizar a tabela e atualizar a paginação
    renderStudentsTable()
    updatePagination()
  }

  if (studentForm) {
    studentForm.addEventListener("submit", (e) => {
      e.preventDefault()

      // Validar idade
      const dobInput = document.getElementById("student-dob")
      const isValidAge = validateMinimumAge(dobInput.value)

      if (!isValidAge) {
        showErrorMessage(dobInput, "O aluno deve ter pelo menos 5 anos de idade para se cadastrar.")
        dobInput.scrollIntoView({ behavior: "smooth", block: "center" })
        return false
      }

      // Validar BI
      const biNumberInput = document.getElementById("bi-number")
      const isValidBI = validateBI(biNumberInput.value.trim())

      if (!isValidBI) {
        showErrorMessage(
          biNumberInput,
          "O BI deve seguir o formato: 7 números + 2 letras + 3 números (Ex: 0000000LA000)",
        )
        biNumberInput.scrollIntoView({ behavior: "smooth", block: "center" })
        return false
      }

      // Validar arquivos do BI
      const biFrontInput = document.getElementById("bi-front")
      const biBackInput = document.getElementById("bi-back")

      // Só validar os arquivos se não estivermos editando
      if (!currentStudentId) {
        if (!biFrontInput.files || !biFrontInput.files[0]) {
          showErrorMessage(biFrontInput, "É necessário fazer upload da frente do BI")
          biFrontInput.scrollIntoView({ behavior: "smooth", block: "center" })
          return false
        }

        if (!biBackInput.files || !biBackInput.files[0]) {
          showErrorMessage(biBackInput, "É necessário fazer upload do verso do BI")
          biBackInput.scrollIntoView({ behavior: "smooth", block: "center" })
          return false
        }
      }

      // Validar senha
      const passwordInput = document.getElementById("password")
      // Só validar a senha se não estivermos editando ou se a senha foi alterada
      if (!currentStudentId || passwordInput.value) {
        const passwordValidation = validatePassword(passwordInput.value)

        if (!passwordValidation.isValid) {
          let errorMsg = "A senha deve conter:"
          if (!passwordValidation.errors.minLength) errorMsg += "<br>- Pelo menos 8 caracteres"
          if (!passwordValidation.errors.hasUpperCase) errorMsg += "<br>- Pelo menos uma letra maiúscula"
          if (!passwordValidation.errors.hasLowerCase) errorMsg += "<br>- Pelo menos uma letra minúscula"
          if (!passwordValidation.errors.hasNumber) errorMsg += "<br>- Pelo menos um número"
          if (!passwordValidation.errors.hasSpecialChar)
            errorMsg += "<br>- Pelo menos um caractere especial (!@#$%^&*...)"

          showErrorMessage(passwordInput, errorMsg)
          passwordInput.scrollIntoView({ behavior: "smooth", block: "center" })
          return false
        }
      }

      // Se todas as validações passarem, coletar os dados do formulário
      const formData = {
        id:
          currentStudentId ||
          "STU" +
            Math.floor(Math.random() * 1000)
              .toString()
              .padStart(3, "0"),
        name: document.getElementById("student-name").value,
        class: document.getElementById("student-class").value,
        gender: document.getElementById("student-gender").value,
        contact: document.getElementById("country-code").value + " " + document.getElementById("student-contact").value,
        attendance: currentStudentId
          ? allStudents.find((s) => s.id === currentStudentId)?.attendance || "90%"
          : Math.floor(Math.random() * 15 + 85) + "%", // Valor aleatório entre 85% e 99%
      }

      // Adicionar o aluno à tabela
      addStudentToTable(formData)

      // Fechar o modal e limpar o formulário
      studentModal.style.display = "none"
      studentForm.reset()
      clearAllErrorMessages()
      document.getElementById("bi-front-preview").innerHTML = ""
      document.getElementById("bi-back-preview").innerHTML = ""

      // Mostrar mensagem de sucesso
      alert(currentStudentId ? "Aluno atualizado com sucesso!" : "Aluno salvo com sucesso!")

      // Resetar o ID do estudante atual
      currentStudentId = null
    })
  }

  if (teacherForm) {
    teacherForm.addEventListener("submit", (e) => {
      e.preventDefault()
      // Here you would typically collect form data and send to server
      alert("Funcionário salvo com sucesso!")
      teacherModal.style.display = "none"
    })
  }

  // Remova o event listener existente para o filtro de classe, pois agora ele será tratado pela função setupClassNavigation

  // Remova ou comente este bloco:
  /*
  // Class filter functionality
  const classFilter = document.getElementById("class-filter")

  // Modifique a função de filtro de classe para trabalhar com o array completo
  if (classFilter && studentTableBody) {
    classFilter.addEventListener("change", function () {
      const filterValue = this.value;
      
      if (filterValue === "") {
        // Se o filtro estiver vazio, mostrar a tabela normal com paginação
        renderStudentsTable();
        updatePagination();
      } else {
        // Filtrar os estudantes que correspondem à classe selecionada
        const filteredStudents = allStudents.filter(student => 
          student.class.includes(filterValue)
        );
        
        // Limpar a tabela
        studentTableBody.innerHTML = "";
        
        // Mostrar apenas os resultados filtrados (sem paginação)
        filteredStudents.forEach(student => {
          const newRow = document.createElement("tr");
          newRow.innerHTML = `
            <td>${student.id}</td>
            <td class="font-medium">${student.name}</td>
            <td>${student.class}</td>
            <td>${student.gender}</td>
            <td>${student.contact}</td>
            <td>
              <span class="status-badge bg-green-50 text-green-700 hover:bg-green-50">
                ${student.attendance}
              </span>
            </td>
            <td>
              <div class="flex gap-2">
                <button class="action-btn edit" title="Editar" data-id="${student.id}"><i class="fas fa-edit"></i></button>
                <button class="action-btn view" title="Ver" data-id="${student.id}"><i class="fas fa-eye"></i></button>
                <button class="action-btn delete" title="Eliminar" data-id="${student.id}"><i class="fas fa-trash"></i></button>
              </div>
            </td>
          `;
          
          studentTableBody.appendChild(newRow);
        });
        
        // Adicionar event listeners para os botões de ação
        addActionButtonListeners();
      }
    });
  }
  */

  // Remova também o event listener existente para o filtro de classe na tabela de presença
  // Já que agora ele será tratado pela função setupClassNavigation

  // Remova ou comente este bloco:
  /*
  // Adicionar event listeners para os filtros da tabela de presença
  const attendanceClassFilter = document.getElementById("attendance-class-filter");
  const attendanceDateFilter = document.getElementById("attendance-date");
  const attendanceSearch = document.getElementById("attendance-search");

  if (attendanceClassFilter) {
    attendanceClassFilter.addEventListener("change", function() {
      currentPage = 1;
      renderAttendanceTable();
      updateAttendancePagination();
    });
  }
  */

  // Mantenha os event listeners para data e pesquisa
  // Adicionar event listeners para os filtros da tabela de presença
  const attendanceDateFilter = document.getElementById("attendance-date")
  const attendanceSearch = document.getElementById("attendance-search")

  if (attendanceDateFilter) {
    attendanceDateFilter.addEventListener("change", () => {
      currentPage = 1
      renderAttendanceTable()
      updateAttendancePagination()
    })
  }

  if (attendanceSearch) {
    attendanceSearch.addEventListener("input", () => {
      currentPage = 1
      renderAttendanceTable()
      updateAttendancePagination()
    })
  }

  // Student search functionality
  const studentSearch = document.getElementById("student-search")
  const studentTableBody = document.getElementById("student-table-body")

  // Modifique a função de pesquisa para trabalhar com o array completo
  if (studentSearch && studentTableBody) {
    studentSearch.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase()

      if (searchTerm === "") {
        // Se a pesquisa estiver vazia, mostrar a tabela normal com paginação
        renderStudentsTable()
        updatePagination()
      } else {
        // Filtrar os estudantes que correspondem à pesquisa
        const filteredStudents = allStudents.filter(
          (student) => student.name.toLowerCase().includes(searchTerm) || student.id.toLowerCase().includes(searchTerm),
        )

        // Limpar a tabela
        studentTableBody.innerHTML = ""

        // Mostrar apenas os resultados filtrados (sem paginação)
        filteredStudents.forEach((student) => {
          const newRow = document.createElement("tr")
          newRow.innerHTML = `
            <td>${student.id}</td>
            <td class="font-medium">${student.name}</td>
            <td>${student.class}</td>
            <td>${student.gender}</td>
            <td>${student.contact}</td>
            <td>
              <span class="status-badge bg-green-50 text-green-700 hover:bg-green-50">
                ${student.attendance}
              </span>
            </td>
            <td>
              <div class="flex gap-2">
                <button class="action-btn edit" title="Editar" data-id="${student.id}"><i class="fas fa-edit"></i></button>
                <button class="action-btn view" title="Ver" data-id="${student.id}"><i class="fas fa-eye"></i></button>
                <button class="action-btn delete" title="Eliminar" data-id="${student.id}"><i class="fas fa-trash"></i></button>
              </div>
            </td>
          `

          studentTableBody.appendChild(newRow)
        })

        // Adicionar event listeners para os botões de ação
        addActionButtonListeners()
      }
    })
  }

  // Class filter functionality
  const classFilter = document.getElementById("class-filter")

  // Modifique a função de filtro de classe para trabalhar com o array completo
  if (classFilter && studentTableBody) {
    classFilter.addEventListener("change", function () {
      const filterValue = this.value

      if (filterValue === "") {
        // Se o filtro estiver vazio, mostrar a tabela normal com paginação
        renderStudentsTable()
        updatePagination()
      } else {
        // Filtrar os estudantes que correspondem à classe selecionada
        const filteredStudents = allStudents.filter((student) => student.class.includes(filterValue))

        // Limpar a tabela
        studentTableBody.innerHTML = ""

        // Mostrar apenas os resultados filtrados (sem paginação)
        filteredStudents.forEach((student) => {
          const newRow = document.createElement("tr")
          newRow.innerHTML = `
            <td>${student.id}</td>
            <td class="font-medium">${student.name}</td>
            <td>${student.class}</td>
            <td>${student.gender}</td>
            <td>${student.contact}</td>
            <td>
              <span class="status-badge bg-green-50 text-green-700 hover:bg-green-50">
                ${student.attendance}
              </span>
            </td>
            <td>
              <div class="flex gap-2">
                <button class="action-btn edit" title="Editar" data-id="${student.id}"><i class="fas fa-edit"></i></button>
                <button class="action-btn view" title="Ver" data-id="${student.id}"><i class="fas fa-eye"></i></button>
                <button class="action-btn delete" title="Eliminar" data-id="${student.id}"><i class="fas fa-trash"></i></button>
              </div>
            </td>
          `

          studentTableBody.appendChild(newRow)
        })

        // Adicionar event listeners para os botões de ação
        addActionButtonListeners()
      }
    })
  }

  // Mobile sidebar toggle
  const mobileMenuToggle = document.createElement("button")
  mobileMenuToggle.classList.add("mobile-menu-toggle")
  mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>'
  document.querySelector("header").prepend(mobileMenuToggle)

  mobileMenuToggle.addEventListener("click", () => {
    const sidebar = document.querySelector(".sidebar")
    sidebar.classList.toggle("active")
  })

  // Responsive adjustments
  function handleResize() {
    if (window.innerWidth <= 768) {
      document.querySelector(".sidebar").classList.remove("active")
    }
  }

  window.addEventListener("resize", handleResize)

  // Initialize any charts or visualizations here
  // This is a placeholder for actual chart initialization

  // Add mobile menu toggle button styles
  const style = document.createElement("style")
  style.textContent = `
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            margin-right: 15px;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
        }
        
        /* Estilos para o modal de visualização de estudante */
        .student-details {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .detail-row {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }
        
        .detail-label {
            font-weight: 600;
            width: 120px;
            color: #555;
        }
        
        .detail-value {
            flex: 1;
        }
        
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
        }
        
        .close-btn {
            background-color: #f0f0f0;
            color: #666;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color var(--transition-speed) ease;
        }
        
        .close-btn:hover {
            background-color: #e0e0e0;
        }
        
        .danger-btn {
            background-color: var(--danger-color);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color var(--transition-speed) ease;
            margin-left: 10px;
        }
        
        .danger-btn:hover {
            background-color: #c0392b;
        }
        
        /* Estilos para a tabela de presença */
        .attendance-list-container {
            margin-top: 20px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }
        
        .attendance-status {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            outline: none;
        }
        
        .attendance-notes {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            outline: none;
        }
        
        .mb-4 {
            margin-bottom: 20px;
        }
    `
  document.head.appendChild(style)

  // Password toggle functionality
  const passwordToggles = document.querySelectorAll(".password-toggle")

  passwordToggles.forEach((toggle) => {
    toggle.addEventListener("click", function () {
      const passwordInput = this.previousElementSibling
      const icon = this.querySelector("i")

      if (passwordInput.type === "password") {
        passwordInput.type = "text"
        icon.classList.remove("fa-eye")
        icon.classList.add("fa-eye-slash")
      } else {
        passwordInput.type = "password"
        icon.classList.remove("fa-eye-slash")
        icon.classList.add("fa-eye")
      }
    })
  })

  // Function to set selected parent (placeholder for now)
  window.setSelectedParent = (value) => {
    console.log("Selected parent ID:", value)
    // Implement your logic here
  }

  // Add parent button functionality
  const addParentBtn = document.getElementById("add-parent-btn")
  if (addParentBtn) {
    addParentBtn.addEventListener("click", () => {
      alert("Funcionalidade para adicionar novo encarregado será implementada aqui.")
      // Here you would typically open another modal or expand the form
    })
  }

  // File upload preview functionality
  function handleFileSelect(event, previewId) {
    const file = event.target.files[0]
    const preview = document.getElementById(previewId)

    if (file) {
      const reader = new FileReader()

      reader.onload = (e) => {
        preview.innerHTML = `
          <img src="${e.target.result}" alt="Preview">
          <div class="file-name">${file.name}</div>
        `
      }

      reader.readAsDataURL(file)
    } else {
      preview.innerHTML = ""
    }
  }

  // Add event listeners for file inputs
  const biFront = document.getElementById("bi-front")
  const biBack = document.getElementById("bi-back")

  if (biFront) {
    biFront.addEventListener("change", (e) => {
      handleFileSelect(e, "bi-front-preview")
      // Remover mensagem de erro se existir
      removeErrorMessage(biFront)
    })
  }

  if (biBack) {
    biBack.addEventListener("change", (e) => {
      handleFileSelect(e, "bi-back-preview")
      // Remover mensagem de erro se existir
      removeErrorMessage(biBack)
    })
  }

  // Configuração do seletor de código de país
  const countryCodeSelect = document.getElementById("country-code")

  if (countryCodeSelect) {
    // Mapeamento de códigos para nomes de países
    const countryNames = {
      "+244": "Angola",
      "+351": "Portugal",
      "+55": "Brasil",
      "+1": "EUA/Canadá",
      "+34": "Espanha",
      "+258": "Moçambique",
      "+240": "Guiné Equatorial",
      "+239": "São Tomé e Príncipe",
      "+238": "Cabo Verde",
      "+245": "Guiné-Bissau",
      "+27": "África do Sul",
      "+33": "França",
      "+44": "Reino Unido",
      "+49": "Alemanha",
      "+86": "China",
    }

    // Já não precisamos modificar o comportamento do seletor de país
    // pois agora os nomes dos países já estão visíveis no HTML
  }

  // Função para validar a idade mínima
  function validateMinimumAge(dateOfBirth, minimumAge = 5) {
    if (!dateOfBirth) return false

    const birthDate = new Date(dateOfBirth)
    const today = new Date()

    // Calcula a idade
    let age = today.getFullYear() - birthDate.getFullYear()
    const monthDiff = today.getMonth() - birthDate.getMonth()

    // Ajusta a idade se ainda não fez aniversário este ano
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--
    }

    return age >= minimumAge
  }

  // Função para mostrar mensagem de erro
  function showErrorMessage(inputElement, message) {
    // Remove mensagem de erro anterior se existir
    const existingError = inputElement.parentElement.querySelector(".error-message")
    if (existingError) {
      existingError.remove()
    }

    // Cria e adiciona nova mensagem de erro
    const errorElement = document.createElement("div")
    errorElement.className = "error-message"
    errorElement.innerHTML = message
    inputElement.parentElement.appendChild(errorElement)

    // Adiciona classe de erro ao input
    inputElement.classList.add("input-error")
  }

  // Função para remover mensagem de erro
  function removeErrorMessage(inputElement) {
    const existingError = inputElement.parentElement.querySelector(".error-message")
    if (existingError) {
      existingError.remove()
    }

    // Remove classe de erro do input
    inputElement.classList.remove("input-error")
  }

  // Validação de idade mínima
  const dobInput = document.getElementById("student-dob")
  if (dobInput) {
    // Validar quando a data é alterada
    dobInput.addEventListener("change", function () {
      const isValidAge = validateMinimumAge(this.value)

      if (!isValidAge) {
        showErrorMessage(this, "O aluno deve ter pelo menos 5 anos de idade para se cadastrar.")
      } else {
        removeErrorMessage(this)
      }
    })
  }

  // Adicione esta função para inicializar a tabela com dados de exemplo
  function initializeStudentsTable() {
    // Dados de exemplo para a tabela
    const sampleStudents = [
      {
        id: "STU001",
        name: "João Silva",
        class: "Turma 10ª A Informática",
        gender: "Masculino",
        contact: "+244 923 456 789",
        attendance: "90%",
      },
      {
        id: "STU002",
        name: "Maria Santos",
        class: "Turma 10ª A Informática",
        gender: "Feminino",
        contact: "+244 923 456 790",
        attendance: "95%",
      },
      {
        id: "STU003",
        name: "Pedro Oliveira",
        class: "Turma 10ª B Informática",
        gender: "Masculino",
        contact: "+244 923 456 791",
        attendance: "85%",
      },
      {
        id: "STU004",
        name: "Ana Costa",
        class: "Turma 10ª A Informática",
        gender: "Feminino",
        contact: "+244 923 456 792",
        attendance: "92%",
      },
      {
        id: "STU005",
        name: "Carlos Ferreira",
        class: "Turma 11ª Informática",
        gender: "Masculino",
        contact: "+244 923 456 793",
        attendance: "88%",
      },
      {
        id: "STU006",
        name: "Sofia Mendes",
        class: "Turma 11ª Informática",
        gender: "Feminino",
        contact: "+244 923 456 794",
        attendance: "91%",
      },
      {
        id: "STU007",
        name: "António Pereira",
        class: "Turma 12ª Informática",
        gender: "Masculino",
        contact: "+244 923 456 795",
        attendance: "87%",
      },
    ]

    // Adicionar estudantes ao array
    allStudents = sampleStudents

    // Calcular o número total de páginas
    totalPages = Math.ceil(allStudents.length / ITEMS_PER_PAGE)

    // Renderizar a tabela e atualizar a paginação
    renderStudentsTable()
    updatePagination()
  }

  // Função para inicializar a tabela de presença com dados de exemplo
  function initializeAttendanceTable() {
    // Dados de exemplo para a tabela de presença
    const sampleAttendanceRecords = [
      {
        id: "ATT001",
        studentId: "STU001",
        name: "João Silva",
        class: "Turma 10ª A Informática",
        date: "01/04/2025",
        time: "08:15",
        status: "present",
        notes: "-",
      },
      {
        id: "ATT002",
        studentId: "STU002",
        name: "Maria Santos",
        class: "Turma 10ª A Informática",
        date: "01/04/2025",
        time: "08:10",
        status: "present",
        notes: "-",
      },
      {
        id: "ATT003",
        studentId: "STU003",
        name: "Pedro Oliveira",
        class: "Turma 10ª B Informática",
        date: "01/04/2025",
        time: "08:00",
        status: "absent",
        notes: "Doente",
      },
      {
        id: "ATT004",
        studentId: "STU004",
        name: "Ana Costa",
        class: "Turma 10ª A Informática",
        date: "01/04/2025",
        time: "08:30",
        status: "late",
        notes: "Chegou 15 minutos atrasado",
      },
      {
        id: "ATT005",
        studentId: "STU005",
        name: "Carlos Ferreira",
        class: "Turma 11ª Informática",
        date: "01/04/2025",
        time: "08:05",
        status: "present",
        notes: "-",
      },
      {
        id: "ATT006",
        studentId: "STU001",
        name: "João Silva",
        class: "Turma 10ª A Informática",
        date: "02/04/2025",
        time: "08:10",
        status: "present",
        notes: "-",
      },
      {
        id: "ATT007",
        studentId: "STU002",
        name: "Maria Santos",
        class: "Turma 10ª A Informática",
        date: "02/04/2025",
        time: "08:15",
        status: "late",
        notes: "Trânsito",
      },
    ]

    // Adicionar registros ao array
    allAttendanceRecords = sampleAttendanceRecords

    // Calcular o número total de páginas
    totalPages = Math.ceil(allAttendanceRecords.length / ITEMS_PER_PAGE)

    // Renderizar a tabela e atualizar a paginação
    renderAttendanceTable()
    updateAttendancePagination()
  }

  // Adicione esta função após a função initializeAttendanceTable()

  // Função para lidar com a navegação entre turmas
  function setupClassNavigation() {
    // Identificar todos os seletores de turma na aplicação
    const classSelectors = [
      document.getElementById("attendance-class-filter"),
      document.getElementById("class-filter"),
      document.getElementById("mark-attendance-class"),
      document.getElementById("schedule-class-filter"),
      document.getElementById("test-class-filter"),
      document.getElementById("bulletin-class-filter"),
    ]

    // Para cada seletor encontrado, adicionar o event listener
    classSelectors.forEach((selector) => {
      if (selector) {
        selector.addEventListener("change", function () {
          const selectedClass = this.value
          if (selectedClass) {
            navigateToClass(selectedClass, this.id)
          }
        })
      }
    })
  }

  // Função para navegar para a página da turma selecionada
  function navigateToClass(className, selectorId) {
    // Se estamos no mesmo seletor que já está sendo usado para filtrar, apenas aplicar o filtro
    if (selectorId === "attendance-class-filter" && document.getElementById("attendance-table-body")) {
      // Já estamos na página de presença, apenas filtrar
      currentPage = 1
      renderAttendanceTable()
      updateAttendancePagination()
      return
    }

    if (selectorId === "class-filter" && document.getElementById("student-table-body")) {
      // Já estamos na página de estudantes, apenas filtrar
      currentPage = 1
      renderStudentsTable()
      updatePagination()
      return
    }

    // Caso contrário, navegar para a página apropriada com o filtro
    let targetPage = ""

    // Determinar a página de destino com base no contexto
    if (selectorId.includes("attendance")) {
      targetPage = "attendance.html"
    } else if (selectorId.includes("schedule")) {
      targetPage = "schedule.html"
    } else if (selectorId.includes("test")) {
      targetPage = "tests.html"
    } else if (selectorId.includes("bulletin")) {
      targetPage = "bulletins.html"
    } else {
      targetPage = "students.html"
    }

    // Salvar a turma selecionada no localStorage para recuperá-la na página de destino
    localStorage.setItem("selectedClass", className)

    // Navegar para a página de destino
    window.location.href = targetPage
  }

  // Função para aplicar o filtro de turma salvo ao carregar a página
  function applyStoredClassFilter() {
    const storedClass = localStorage.getItem("selectedClass")

    if (storedClass) {
      // Limpar o valor armazenado após usá-lo
      localStorage.removeItem("selectedClass")

      // Identificar qual seletor deve ser atualizado com base na página atual
      let selector = null

      if (window.location.pathname.includes("attendance")) {
        selector = document.getElementById("attendance-class-filter")
      } else if (window.location.pathname.includes("schedule")) {
        selector = document.getElementById("schedule-class-filter")
      } else if (window.location.pathname.includes("tests")) {
        selector = document.getElementById("test-class-filter")
      } else if (window.location.pathname.includes("bulletins")) {
        selector = document.getElementById("bulletin-class-filter")
      } else {
        selector = document.getElementById("class-filter")
      }

      // Atualizar o seletor e aplicar o filtro
      if (selector) {
        selector.value = storedClass

        // Disparar o evento change para aplicar o filtro
        const event = new Event("change")
        selector.dispatchEvent(event)
      }
    }
  }

  // Adicione estas chamadas no final do bloco DOMContentLoaded
  // Configurar a navegação entre turmas
  setupClassNavigation()

  // Aplicar o filtro de turma salvo ao carregar a página
  applyStoredClassFilter()

  // Initialize the students table with sample data
  initializeStudentsTable()

  // Initialize the attendance table with sample data
  initializeAttendanceTable()
})

// Add this to your existing JavaScript file
document.getElementById('student-photo').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
          const previewDiv = document.getElementById('student-photo-preview');
          previewDiv.innerHTML = `
              <div class="preview-item">
                  <img src="${event.target.result}" alt="Foto do aluno">
                  <button type="button" class="remove-file" onclick="removeFile('student-photo')">
                      <i class="fas fa-times"></i>
                  </button>
              </div>
          `;
          previewDiv.style.display = 'block';
      };
      reader.readAsDataURL(file);
  }
});

// If you don't already have this function
function removeFile(inputId) {
  document.getElementById(inputId).value = '';
  document.getElementById(inputId + '-preview').innerHTML = '';
  document.getElementById(inputId + '-preview').style.display = 'none';
}

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = ""; // Limpa preview anterior

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement("img");
            img.src = e.target.result;
            img.style.maxWidth = "120px";
            img.style.borderRadius = "8px";
            preview.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewImage(input, previewId) {
  const file = input.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function () {
      document.getElementById(previewId).innerHTML = `<img src="${reader.result}" style="max-height:100px;">`;
    };
    reader.readAsDataURL(file);
  }
}

document.getElementById("bi-front").addEventListener("change", function () {
  previewImage(this, "bi-front-preview");
});
document.getElementById("bi-back").addEventListener("change", function () {
  previewImage(this, "bi-back-preview");
});
document.getElementById("student-photo").addEventListener("change", function () {
  previewImage(this, "student-photo-preview");
});

// Função para lidar com a visualização prévia de imagens
document.addEventListener("DOMContentLoaded", () => {
  // Seleciona todos os inputs de arquivo
  const fileInputs = document.querySelectorAll('input[type="file"]')

  // Adiciona um event listener para cada input de arquivo
  fileInputs.forEach((input) => {
    input.addEventListener("change", function (e) {
      // Obtém o ID do elemento de visualização correspondente
      const previewId = this.id + "-preview"
      const previewElement = document.getElementById(previewId)

      if (previewElement) {
        // Limpa a visualização anterior
        previewElement.innerHTML = ""

        // Verifica se um arquivo foi selecionado
        if (this.files && this.files[0]) {
          const file = this.files[0]

          // Verifica se o arquivo é uma imagem
          if (file.type.match("image.*")) {
            const reader = new FileReader()

            reader.onload = (e) => {
              // Cria um elemento de imagem para a visualização
              const img = document.createElement("img")
              img.src = e.target.result
              img.className = "preview-image"

              // Adiciona a imagem ao elemento de visualização
              previewElement.appendChild(img)

              // Adiciona um botão para remover a imagem
              const removeBtn = document.createElement("button")
              removeBtn.type = "button"
              removeBtn.className = "remove-image"
              removeBtn.innerHTML = '<i class="fas fa-times"></i>'
              removeBtn.addEventListener("click", () => {
                // Limpa o input de arquivo e a visualização
                input.value = ""
                previewElement.innerHTML = ""
              })

              previewElement.appendChild(removeBtn)
            }

            // Lê o arquivo como uma URL de dados
            reader.readAsDataURL(file)
          } else {
            // Se não for uma imagem, exibe uma mensagem de erro
            previewElement.innerHTML = '<p class="error">Por favor, selecione um arquivo de imagem válido.</p>'
          }
        }
      }
    })
  })

  // Adiciona funcionalidade para mostrar/ocultar senha
  const passwordToggles = document.querySelectorAll(".password-toggle")
  passwordToggles.forEach((toggle) => {
    toggle.addEventListener("click", function () {
      const passwordInput = this.parentElement.querySelector("input")
      const icon = this.querySelector("i")

      if (passwordInput.type === "password") {
        passwordInput.type = "text"
        icon.classList.remove("fa-eye")
        icon.classList.add("fa-eye-slash")
      } else {
        passwordInput.type = "password"
        icon.classList.remove("fa-eye-slash")
        icon.classList.add("fa-eye")
      }
    })
  })
})
