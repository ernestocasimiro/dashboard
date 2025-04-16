document.addEventListener("DOMContentLoaded", () => {
    // Get DOM elements
    const composeBtn = document.querySelector(".btn-compose")
    const composeModal = document.getElementById("composeModal")
    const closeModalBtn = document.querySelector(".close-modal")
    const messageItems = document.querySelectorAll(".message-item")
    const filterBtns = document.querySelectorAll(".filter-btn")
  
    // Toggle compose modal
    if (composeBtn && composeModal) {
      composeBtn.addEventListener("click", () => {
        composeModal.style.display = "flex"
      })
    }
  
    // Close modal
    if (closeModalBtn && composeModal) {
      closeModalBtn.addEventListener("click", () => {
        composeModal.style.display = "none"
      })
  
      // Close modal when clicking outside
      window.addEventListener("click", (event) => {
        if (event.target === composeModal) {
          composeModal.style.display = "none"
        }
      })
    }
  
    // Message item click handler
    messageItems.forEach((item) => {
      item.addEventListener("click", function () {
        // Remove active class from all items
        messageItems.forEach((i) => i.classList.remove("active"))
  
        // Add active class to clicked item
        this.classList.add("active")
  
        // Mark as read (remove unread class)
        this.classList.remove("unread")
  
        // In a real application, you would load the message content here
        // For this demo, we'll just use the existing content
      })
    })
  
    // Filter buttons click handler
    filterBtns.forEach((btn) => {
      btn.addEventListener("click", function () {
        // Remove active class from all filter buttons
        filterBtns.forEach((b) => b.classList.remove("active"))
  
        // Add active class to clicked button
        this.classList.add("active")
  
        const filter = this.getAttribute("data-filter")
  
        // In a real application, you would filter messages based on the selected filter
        console.log("Filter selected:", filter)
      })
    })
  
    // Handle reply form submission
    const replyForm = document.querySelector(".message-reply")
    const sendBtn = document.querySelector(".btn-send")
  
    if (replyForm && sendBtn) {
      sendBtn.addEventListener("click", () => {
        const replyText = replyForm.querySelector("textarea").value
  
        if (replyText.trim() !== "") {
          // In a real application, you would send the reply to the server
          console.log("Reply sent:", replyText)
  
          // Clear the textarea
          replyForm.querySelector("textarea").value = ""
  
          // Show a success message
          alert("Resposta enviada com sucesso!")
        } else {
          alert("Por favor, escreva uma resposta antes de enviar.")
        }
      })
    }
  
    // Handle compose form submission
    const composeForm = document.getElementById("composeForm")
  
    if (composeForm) {
      composeForm.addEventListener("submit", (event) => {
        event.preventDefault()
  
        const recipient = document.getElementById("recipient").value
        const subject = document.getElementById("subject").value
        const message = document.getElementById("message").value
  
        if (recipient.trim() === "" || subject.trim() === "" || message.trim() === "") {
          alert("Por favor, preencha todos os campos obrigatórios.")
          return
        }
  
        // In a real application, you would send the message to the server
        console.log("Message sent:", {
          recipient,
          subject,
          message,
        })
  
        // Clear the form
        composeForm.reset()
  
        // Close the modal
        composeModal.style.display = "none"
  
        // Show a success message
        alert("Mensagem enviada com sucesso!")
      })
    }
  })
  