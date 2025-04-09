document.addEventListener("DOMContentLoaded", () => {
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
  const studentModal = document.getElementById("student-modal")
  const teacherModal = document.getElementById("teacher-modal")
  const closeModalBtns = document.querySelectorAll(".close-modal")
  const cancelBtns = document.querySelectorAll(".cancel-btn")

  // Open student modal
  if (addStudentBtn) {
    addStudentBtn.addEventListener("click", () => {
      studentModal.style.display = "block"
    })
  }

  // Open teacher modal
  if (addTeacherBtn) {
    addTeacherBtn.addEventListener("click", () => {
      teacherModal.style.display = "block"
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
    })
  })

  // Close modals when clicking outside
  window.addEventListener("click", (event) => {
    if (event.target.classList.contains("modal")) {
      event.target.style.display = "none"
    }
  })

  // Form submission
  const studentForm = document.getElementById("student-form")
  const teacherForm = document.getElementById("teacher-form")

  if (studentForm) {
    studentForm.addEventListener("submit", (e) => {
      e.preventDefault()
      // Here you would typically collect form data and send to server
      alert("Aluno salvo com sucesso!")
      studentModal.style.display = "none"
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

  // Student search functionality
  const studentSearch = document.getElementById("student-search")
  const studentTableBody = document.getElementById("student-table-body")

  if (studentSearch && studentTableBody) {
    studentSearch.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase()
      const rows = studentTableBody.querySelectorAll("tr")

      rows.forEach((row) => {
        const name = row.querySelector("td:nth-child(2)").textContent.toLowerCase()
        const id = row.querySelector("td:nth-child(1)").textContent.toLowerCase()

        if (name.includes(searchTerm) || id.includes(searchTerm)) {
          row.style.display = ""
        } else {
          row.style.display = "none"
        }
      })
    })
  }

  // Class filter functionality
  const classFilter = document.getElementById("class-filter")

  if (classFilter && studentTableBody) {
    classFilter.addEventListener("change", function () {
      const filterValue = this.value
      const rows = studentTableBody.querySelectorAll("tr")

      if (filterValue === "") {
        rows.forEach((row) => {
          row.style.display = ""
        })
      } else {
        rows.forEach((row) => {
          const classValue = row.querySelector("td:nth-child(3)").textContent
          if (classValue.includes(filterValue)) {
            row.style.display = ""
          } else {
            row.style.display = "none"
          }
        })
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
    })
  }

  if (biBack) {
    biBack.addEventListener("change", (e) => {
      handleFileSelect(e, "bi-back-preview")
    })
  }

  // Adicione este código após a função handleFileSelect

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

    // Adicionar os nomes dos países aos options quando o select é clicado
    countryCodeSelect.addEventListener("mousedown", function () {
      const options = this.querySelectorAll("option")
      options.forEach((option) => {
        const code = option.value
        if (countryNames[code] && !option.dataset.modified) {
          option.textContent = `${code} (${countryNames[code]})`
          option.dataset.modified = "true"
        }
      })
    })

    // Restaurar apenas o código quando o select perde o foco
    countryCodeSelect.addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex]
      const code = selectedOption.value

      // Armazenar o texto completo para restaurar quando abrir novamente
      if (!selectedOption.dataset.fullText) {
        selectedOption.dataset.fullText = selectedOption.textContent
      }

      // Definir apenas o código como texto visível
      setTimeout(() => {
        this.querySelectorAll("option").forEach((option) => {
          if (option.dataset.modified) {
            const code = option.value
            option.textContent = code
          }
        })
      }, 100)
    })

    // Inicializar com apenas os códigos
    const options = countryCodeSelect.querySelectorAll("option")
    options.forEach((option) => {
      const code = option.value
      if (countryNames[code]) {
        option.dataset.fullText = `${code} (${countryNames[code]})`
        option.textContent = code
      }
    })
  }

  // Adicione esta função após a função handleFileSelect

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
    errorElement.textContent = message
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

  // Adicione este código dentro do bloco DOMContentLoaded, após a configuração do seletor de país

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

    // Modificar o evento de envio do formulário para incluir a validação de idade
    const studentForm = document.getElementById("student-form")
    if (studentForm) {
      // Remover o listener anterior
      const newStudentForm = studentForm.cloneNode(true)
      studentForm.parentNode.replaceChild(newStudentForm, studentForm)

      // Adicionar novo listener com validação
      newStudentForm.addEventListener("submit", (e) => {
        e.preventDefault()

        // Obter a data de nascimento
        const dobInput = document.getElementById("student-dob")
        const isValidAge = validateMinimumAge(dobInput.value)

        if (!isValidAge) {
          showErrorMessage(dobInput, "O aluno deve ter pelo menos 5 anos de idade para se cadastrar.")
          // Rolar até o campo com erro
          dobInput.scrollIntoView({ behavior: "smooth", block: "center" })
          return false
        }

        // Se a idade for válida, continuar com o envio
        alert("Aluno salvo com sucesso!")
        document.getElementById("student-modal").style.display = "none"
      })
    }
  }
})

