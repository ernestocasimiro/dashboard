document.addEventListener("DOMContentLoaded", () => {
    // Period selector
    const periodBtns = document.querySelectorAll(".period-btn")
    const financeMonth = document.getElementById("financeMonth")
  
    // Tab navigation
    const tabBtns = document.querySelectorAll(".tab-btn")
    const tabPanels = document.querySelectorAll(".tab-panel")
  
    // Transaction modal
    const addTransactionBtn = document.querySelector(".btn-add-transaction")
    const transactionModal = document.getElementById("transactionModal")
    const closeModalBtn = document.querySelector(".close-modal")
    const cancelBtn = document.querySelector(".btn-cancel")
    const transactionForm = document.getElementById("transactionForm")
  
    // Filter dropdown
    const filterBtn = document.querySelector(".btn-filter")
    const filterMenu = document.querySelector(".filter-menu")
  
    // Period selector functionality
    if (periodBtns.length > 0) {
      periodBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
          // Remove active class from all period buttons
          periodBtns.forEach((b) => b.classList.remove("active"))
  
          // Add active class to clicked button
          this.classList.add("active")
  
          // In a real application, you would update the data based on the selected period
          const period = this.getAttribute("data-period")
          console.log("Period selected:", period)
        })
      })
    }
  
    // Tab navigation functionality
    if (tabBtns.length > 0 && tabPanels.length > 0) {
      tabBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
          // Remove active class from all tab buttons and panels
          tabBtns.forEach((b) => b.classList.remove("active"))
          tabPanels.forEach((p) => p.classList.remove("active"))
  
          // Add active class to clicked button
          this.classList.add("active")
  
          // Show the corresponding panel
          const tabId = this.getAttribute("data-tab")
          const panel = document.getElementById(tabId + "-panel")
          if (panel) {
            panel.classList.add("active")
          }
        })
      })
    }
  
    // Transaction modal functionality
    if (addTransactionBtn && transactionModal) {
      addTransactionBtn.addEventListener("click", () => {
        transactionModal.style.display = "flex"
      })
    }
  
    if (closeModalBtn && transactionModal) {
      closeModalBtn.addEventListener("click", () => {
        transactionModal.style.display = "none"
      })
    }
  
    if (cancelBtn && transactionModal) {
      cancelBtn.addEventListener("click", () => {
        transactionModal.style.display = "none"
      })
    }
  
    // Close modal when clicking outside
    window.addEventListener("click", (event) => {
      if (event.target === transactionModal) {
        transactionModal.style.display = "none"
      }
    })
  
    // Filter dropdown functionality
    if (filterBtn && filterMenu) {
      filterBtn.addEventListener("click", (event) => {
        event.stopPropagation()
        filterMenu.classList.toggle("show")
      })
  
      // Close filter menu when clicking outside
      document.addEventListener("click", (event) => {
        if (!filterBtn.contains(event.target) && !filterMenu.contains(event.target)) {
          filterMenu.classList.remove("show")
        }
      })
    }
  
    // Transaction form submission
    if (transactionForm) {
      transactionForm.addEventListener("submit", (event) => {
        event.preventDefault()
  
        const type = document.getElementById("transactionType").value
        const date = document.getElementById("transactionDate").value
        const description = document.getElementById("transactionDescription").value
        const category = document.getElementById("transactionCategory").value
        const amount = document.getElementById("transactionAmount").value
        const notes = document.getElementById("transactionNotes").value
  
        if (description.trim() === "" || amount.trim() === "") {
          alert("Por favor, preencha todos os campos obrigatórios.")
          return
        }
  
        // In a real application, you would send the transaction data to the server
        console.log("Transaction saved:", {
          type,
          date,
          description,
          category,
          amount,
          notes,
        })
  
        // Clear the form
        transactionForm.reset()
  
        // Close the modal
        transactionModal.style.display = "none"
  
        // Show a success message
        alert("Transação registrada com sucesso!")
      })
    }
  
    // Chart hover effects
    const bars = document.querySelectorAll(".bar")
    if (bars.length > 0) {
      bars.forEach((bar) => {
        bar.addEventListener("mouseenter", function () {
          this.style.opacity = "0.8"
        })
  
        bar.addEventListener("mouseleave", function () {
          this.style.opacity = "1"
        })
      })
    }
  
    // Export buttons functionality
    const exportButtons = document.querySelectorAll(".btn-export")
    if (exportButtons.length > 0) {
      exportButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
          // In a real application, you would implement export functionality
          alert("Exportação iniciada. O arquivo será baixado em breve.")
        })
      })
    }
  
    // Generate invoices button functionality
    const generateInvoicesBtn = document.querySelector(".btn-generate-invoices")
    if (generateInvoicesBtn) {
      generateInvoicesBtn.addEventListener("click", () => {
        // In a real application, you would implement invoice generation
        alert("Geração de faturas iniciada. As faturas serão processadas em breve.")
      })
    }
  
    // Send reminders button functionality
    const sendRemindersBtn = document.querySelector(".btn-send-reminders")
    if (sendRemindersBtn) {
      sendRemindersBtn.addEventListener("click", () => {
        // In a real application, you would implement sending reminders
        alert("Lembretes de pagamento serão enviados para os responsáveis.")
      })
    }
  
    // Process payroll button functionality
    const processPayrollBtn = document.querySelector(".btn-process-payroll")
    if (processPayrollBtn) {
      processPayrollBtn.addEventListener("click", () => {
        // In a real application, you would implement payroll processing
        alert("Processamento da folha de pagamento iniciado.")
      })
    }
  
    // Edit budget button functionality
    const editBudgetBtn = document.querySelector(".btn-edit-budget")
    if (editBudgetBtn) {
      editBudgetBtn.addEventListener("click", () => {
        // In a real application, you would open a budget editing form
        alert("Edição de orçamento não disponível nesta versão de demonstração.")
      })
    }
  })
  