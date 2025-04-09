document.addEventListener("DOMContentLoaded", () => {
  // Exibir data atual
  const currentDate = document.getElementById("current-date")
  if (currentDate) {
    const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" }
    const today = new Date()
    currentDate.textContent = today.toLocaleDateString("pt-BR", options)
  }

  // Tab Navigation
  const navLinks = document.querySelectorAll(".nav-links li")
  const tabPanes = document.querySelectorAll(".tab-pane")

  navLinks.forEach((link) => {
    link.addEventListener("click", function () {
      // Remove active class from all links and panes
      navLinks.forEach((l) => l.classList.remove("active"))
      tabPanes.forEach((p) => p.classList.remove("active"))

      // Add active class to clicked link
      this.classList.add("active")

      // Show corresponding tab pane
      const tabId = this.getAttribute("data-tab")
      document.getElementById(tabId).classList.add("active")
    })
  })

  // Modal Functionality
  const modals = document.querySelectorAll(".modal")
  const closeButtons = document.querySelectorAll(".close-modal")
  const cancelButtons = document.querySelectorAll(".cancel-btn")

  // Abrir modal de turma
  const addTurmaBtn = document.getElementById("add-turma-btn")
  if (addTurmaBtn) {
    addTurmaBtn.addEventListener("click", () => {
      document.getElementById("turma-modal").style.display = "flex"
    })
  }

  // Abrir modal de atividade
  const addAtividadeBtn = document.getElementById("add-atividade-btn")
  if (addAtividadeBtn) {
    addAtividadeBtn.addEventListener("click", () => {
      document.getElementById("atividade-modal").style.display = "flex"
    })
  }

  // Abrir modal de frequência
  const registrarFrequenciaBtn = document.getElementById("registrar-frequencia-btn")
  if (registrarFrequenciaBtn) {
    registrarFrequenciaBtn.addEventListener("click", () => {
      document.getElementById("frequencia-modal").style.display = "flex"
    })
  }

  // Open Student Modal
  document.getElementById("add-student-btn")?.addEventListener("click", () => {
    document.getElementById("student-modal").style.display = "flex"
  })

  // Open Teacher Modal
  document.getElementById("add-teacher-btn")?.addEventListener("click", () => {
    document.getElementById("teacher-modal").style.display = "flex"
  })

  // Open Course Modal
  document.getElementById("add-course-btn")?.addEventListener("click", () => {
    document.getElementById("course-modal").style.display = "flex"
  })

  // Open Attendance Modal
  document.getElementById("take-attendance-btn")?.addEventListener("click", () => {
    document.getElementById("attendance-modal").style.display = "flex"
    populateAttendanceList()
  })

  // Open Grade Modal
  document.getElementById("add-grade-btn")?.addEventListener("click", () => {
    document.getElementById("grade-modal").style.display = "flex"
    populateGradeList()
  })

  // Close Modals
  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      this.closest(".modal").style.display = "none"
    })
  })

  cancelButtons.forEach((button) => {
    button.addEventListener("click", function () {
      this.closest(".modal").style.display = "none"
    })
  })

  // Close modal when clicking outside
  modals.forEach((modal) => {
    modal.addEventListener("click", function (e) {
      if (e.target === this) {
        this.style.display = "none"
      }
    })
  })

  // Submissão de formulários
  const turmaForm = document.getElementById("turma-form")
  if (turmaForm) {
    turmaForm.addEventListener("submit", function (e) {
      e.preventDefault()
      alert("Turma adicionada com sucesso!")
      document.getElementById("turma-modal").style.display = "none"
      this.reset()
    })
  }

  const atividadeForm = document.getElementById("atividade-form")
  if (atividadeForm) {
    atividadeForm.addEventListener("submit", function (e) {
      e.preventDefault()
      alert("Atividade adicionada com sucesso!")
      document.getElementById("atividade-modal").style.display = "none"
      this.reset()
    })
  }

  const frequenciaForm = document.getElementById("frequencia-form")
  if (frequenciaForm) {
    frequenciaForm.addEventListener("submit", function (e) {
      e.preventDefault()
      alert("Frequência registrada com sucesso!")
      document.getElementById("frequencia-modal").style.display = "none"
      this.reset()
    })
  }

  // Form Submissions
  document.getElementById("student-form")?.addEventListener("submit", function (e) {
    e.preventDefault()
    // Here you would typically send data to a server
    // For demo purposes, we'll just close the modal and show a success message
    alert("Student added successfully!")
    document.getElementById("student-modal").style.display = "none"
    this.reset()
  })

  document.getElementById("teacher-form")?.addEventListener("submit", function (e) {
    e.preventDefault()
    alert("Teacher added successfully!")
    document.getElementById("teacher-modal").style.display = "none"
    this.reset()
  })

  document.getElementById("course-form")?.addEventListener("submit", function (e) {
    e.preventDefault()
    alert("Course added successfully!")
    document.getElementById("course-modal").style.display = "none"
    this.reset()
    // Add the course to the grid
    addCourseToGrid()
  })

  document.getElementById("attendance-form")?.addEventListener("submit", function (e) {
    e.preventDefault()
    alert("Attendance recorded successfully!")
    document.getElementById("attendance-modal").style.display = "none"
    this.reset()
    // Add the attendance record to the table
    addAttendanceRecord()
  })

  document.getElementById("grade-form")?.addEventListener("submit", function (e) {
    e.preventDefault()
    alert("Grades recorded successfully!")
    document.getElementById("grade-modal").style.display = "none"
    this.reset()
    // Add the grade record to the table
    addGradeRecord()
  })

  // Settings Forms
  document.getElementById("profile-form")?.addEventListener("submit", (e) => {
    e.preventDefault()
    alert("Profile updated successfully!")
  })

  document.getElementById("password-form")?.addEventListener("submit", function (e) {
    e.preventDefault()
    alert("Password updated successfully!")
    this.reset()
  })

  document.getElementById("notification-form")?.addEventListener("submit", (e) => {
    e.preventDefault()
    alert("Notification preferences saved!")
  })

  document.getElementById("system-form")?.addEventListener("submit", (e) => {
    e.preventDefault()
    alert("System settings updated!")
  })

  // Funcionalidade de busca de frequência
  const buscarFrequenciaBtn = document.getElementById("buscar-frequencia-btn")
  if (buscarFrequenciaBtn) {
    buscarFrequenciaBtn.addEventListener("click", () => {
      const turma = document.getElementById("frequencia-turma-filter").value
      const data = document.getElementById("frequencia-data").value

      if (!turma) {
        alert("Por favor, selecione uma turma.")
        return
      }

      // Aqui você faria uma requisição para buscar os dados de frequência
      // Para este exemplo, apenas exibimos uma mensagem
      alert(`Buscando frequência da turma ${turma} na data ${data}`)
    })
  }

  // Funcionalidade de salvar notas
  const saveButtons = document.querySelectorAll(".action-btn.save")
  saveButtons.forEach((button) => {
    button.addEventListener("click", () => {
      // Aqui você salvaria as notas no banco de dados
      // Para este exemplo, apenas exibimos uma mensagem
      alert("Notas salvas com sucesso!")
    })
  })

  // Funcionalidade de filtro de alunos
  const alunoSearch = document.getElementById("aluno-search")
  if (alunoSearch) {
    alunoSearch.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase()
      const rows = document.querySelectorAll("#alunos .data-table tbody tr")

      rows.forEach((row) => {
        const nome = row.cells[1].textContent.toLowerCase()
        if (nome.includes(searchTerm)) {
          row.style.display = ""
        } else {
          row.style.display = "none"
        }
      })
    })
  }

  // Funcionalidade de filtro de turmas
  const turmaSearch = document.getElementById("turma-search")
  if (turmaSearch) {
    turmaSearch.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase()
      const cards = document.querySelectorAll(".turma-card")

      cards.forEach((card) => {
        const nome = card.querySelector("h3").textContent.toLowerCase()
        if (nome.includes(searchTerm)) {
          card.style.display = ""
        } else {
          card.style.display = "none"
        }
      })
    })
  }

  // Funcionalidade de filtro de atividades
  const atividadeSearch = document.getElementById("atividade-search")
  if (atividadeSearch) {
    atividadeSearch.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase()
      const cards = document.querySelectorAll(".atividade-card")

      cards.forEach((card) => {
        const nome = card.querySelector("h3").textContent.toLowerCase()
        if (nome.includes(searchTerm)) {
          card.style.display = ""
        } else {
          card.style.display = "none"
        }
      })
    })
  }

  // Populate Tables with Sample Data
  populateStudentTable()
  populateTeacherTable()
  populateCourseGrid()
  populateAttendanceTable()
  populateGradeTable()
})

// Sample Data Functions
function populateStudentTable() {
  const tableBody = document.getElementById("student-table-body")
  if (!tableBody) return

  const students = [
    {
      id: "STU001",
      name: "John Smith",
      class: "Class 10",
      gender: "Male",
      contact: "+1 (555) 123-4567",
      attendance: "95%",
    },
    {
      id: "STU002",
      name: "Emily Johnson",
      class: "Class 11",
      gender: "Female",
      contact: "+1 (555) 234-5678",
      attendance: "92%",
    },
    {
      id: "STU003",
      name: "Michael Brown",
      class: "Class 12",
      gender: "Male",
      contact: "+1 (555) 345-6789",
      attendance: "88%",
    },
    {
      id: "STU004",
      name: "Jessica Davis",
      class: "Class 10",
      gender: "Female",
      contact: "+1 (555) 456-7890",
      attendance: "90%",
    },
    {
      id: "STU005",
      name: "David Wilson",
      class: "Class 11",
      gender: "Male",
      contact: "+1 (555) 567-8901",
      attendance: "85%",
    },
    {
      id: "STU006",
      name: "Sarah Martinez",
      class: "Class 12",
      gender: "Female",
      contact: "+1 (555) 678-9012",
      attendance: "93%",
    },
    {
      id: "STU007",
      name: "James Taylor",
      class: "Class 10",
      gender: "Male",
      contact: "+1 (555) 789-0123",
      attendance: "91%",
    },
    {
      id: "STU008",
      name: "Jennifer Anderson",
      class: "Class 11",
      gender: "Female",
      contact: "+1 (555) 890-1234",
      attendance: "89%",
    },
  ]

  let html = ""
  students.forEach((student) => {
    html += `
            <tr>
                <td>${student.id}</td>
                <td>${student.name}</td>
                <td>${student.class}</td>
                <td>${student.gender}</td>
                <td>${student.contact}</td>
                <td>${student.attendance}</td>
                <td>
                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `
  })

  tableBody.innerHTML = html
}

function populateTeacherTable() {
  const tableBody = document.getElementById("teacher-table-body")
  if (!tableBody) return

  const teachers = [
    {
      id: "TCH001",
      name: "Dr. Robert Johnson",
      department: "Science",
      contact: "+1 (555) 111-2222",
      subjects: "Physics, Chemistry",
      experience: "10 years",
    },
    {
      id: "TCH002",
      name: "Prof. Mary Williams",
      department: "Mathematics",
      contact: "+1 (555) 222-3333",
      subjects: "Algebra, Calculus",
      experience: "8 years",
    },
    {
      id: "TCH003",
      name: "Mr. James Brown",
      department: "English",
      contact: "+1 (555) 333-4444",
      subjects: "Literature, Grammar",
      experience: "5 years",
    },
    {
      id: "TCH004",
      name: "Mrs. Patricia Davis",
      department: "History",
      contact: "+1 (555) 444-5555",
      subjects: "World History, Civics",
      experience: "7 years",
    },
    {
      id: "TCH005",
      name: "Dr. Michael Wilson",
      department: "Computer Science",
      contact: "+1 (555) 555-6666",
      subjects: "Programming, Web Development",
      experience: "6 years",
    },
    {
      id: "TCH006",
      name: "Ms. Elizabeth Taylor",
      department: "Science",
      contact: "+1 (555) 666-7777",
      subjects: "Biology, Environmental Science",
      experience: "4 years",
    },
  ]

  let html = ""
  teachers.forEach((teacher) => {
    html += `
            <tr>
                <td>${teacher.id}</td>
                <td>${teacher.name}</td>
                <td>${teacher.department}</td>
                <td>${teacher.contact}</td>
                <td>${teacher.subjects}</td>
                <td>${teacher.experience}</td>
                <td>
                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `
  })

  tableBody.innerHTML = html
}

function populateCourseGrid() {
  const courseGrid = document.getElementById("course-grid")
  if (!courseGrid) return

  const courses = [
    {
      id: "CRS001",
      name: "Physics 101",
      code: "PHY101",
      type: "Core",
      department: "Science",
      credits: 4,
      capacity: 30,
    },
    {
      id: "CRS002",
      name: "Calculus I",
      code: "MAT201",
      type: "Core",
      department: "Mathematics",
      credits: 3,
      capacity: 35,
    },
    {
      id: "CRS003",
      name: "English Literature",
      code: "ENG101",
      type: "Core",
      department: "English",
      credits: 3,
      capacity: 40,
    },
    {
      id: "CRS004",
      name: "World History",
      code: "HIS101",
      type: "Elective",
      department: "History",
      credits: 3,
      capacity: 30,
    },
    {
      id: "CRS005",
      name: "Computer Programming",
      code: "CSC101",
      type: "Core",
      department: "Computer Science",
      credits: 4,
      capacity: 25,
    },
    {
      id: "CRS006",
      name: "Chemistry Lab",
      code: "CHM102",
      type: "Laboratory",
      department: "Science",
      credits: 2,
      capacity: 20,
    },
  ]

  let html = ""
  courses.forEach((course) => {
    html += `
            <div class="course-card">
                <div class="course-header">
                    <h4>${course.name}</h4>
                    <p>${course.code}</p>
                </div>
                <div class="course-body">
                    <div class="course-info">
                        <p>Department: <span>${course.department}</span></p>
                        <p>Type: <span>${course.type}</span></p>
                        <p>Credits: <span>${course.credits}</span></p>
                        <p>Capacity: <span>${course.capacity}</span></p>
                    </div>
                    <div class="course-actions">
                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                        <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `
  })

  courseGrid.innerHTML = html
}

function populateAttendanceTable() {
  const tableBody = document.getElementById("attendance-table-body")
  if (!tableBody) return

  const attendanceRecords = [
    {
      class: "Class 10",
      date: "2025-04-01",
      present: 28,
      absent: 2,
      percentage: "93%",
      recordedBy: "Dr. Robert Johnson",
    },
    {
      class: "Class 11",
      date: "2025-04-01",
      present: 30,
      absent: 5,
      percentage: "86%",
      recordedBy: "Prof. Mary Williams",
    },
    { class: "Class 12", date: "2025-04-01", present: 25, absent: 3, percentage: "89%", recordedBy: "Mr. James Brown" },
    {
      class: "Class 10",
      date: "2025-03-31",
      present: 29,
      absent: 1,
      percentage: "97%",
      recordedBy: "Dr. Robert Johnson",
    },
    {
      class: "Class 11",
      date: "2025-03-31",
      present: 32,
      absent: 3,
      percentage: "91%",
      recordedBy: "Prof. Mary Williams",
    },
    { class: "Class 12", date: "2025-03-31", present: 26, absent: 2, percentage: "93%", recordedBy: "Mr. James Brown" },
  ]

  let html = ""
  attendanceRecords.forEach((record) => {
    html += `
            <tr>
                <td>${record.class}</td>
                <td>${record.date}</td>
                <td>${record.present}</td>
                <td>${record.absent}</td>
                <td>${record.percentage}</td>
                <td>${record.recordedBy}</td>
                <td>
                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `
  })

  tableBody.innerHTML = html
}

function populateGradeTable() {
  const tableBody = document.getElementById("grade-table-body")
  if (!tableBody) return

  const gradeRecords = [
    {
      id: "STU001",
      name: "John Smith",
      class: "Class 10",
      subject: "Physics",
      examType: "Midterm",
      marks: 85,
      grade: "A",
    },
    {
      id: "STU002",
      name: "Emily Johnson",
      class: "Class 11",
      subject: "Mathematics",
      examType: "Final",
      marks: 92,
      grade: "A+",
    },
    {
      id: "STU003",
      name: "Michael Brown",
      class: "Class 12",
      subject: "English",
      examType: "Quiz",
      marks: 78,
      grade: "B+",
    },
    {
      id: "STU004",
      name: "Jessica Davis",
      class: "Class 10",
      subject: "Chemistry",
      examType: "Assignment",
      marks: 88,
      grade: "A",
    },
    {
      id: "STU005",
      name: "David Wilson",
      class: "Class 11",
      subject: "History",
      examType: "Midterm",
      marks: 75,
      grade: "B",
    },
    {
      id: "STU006",
      name: "Sarah Martinez",
      class: "Class 12",
      subject: "Computer Science",
      examType: "Final",
      marks: 95,
      grade: "A+",
    },
  ]

  let html = ""
  gradeRecords.forEach((record) => {
    html += `
            <tr>
                <td>${record.id}</td>
                <td>${record.name}</td>
                <td>${record.class}</td>
                <td>${record.subject}</td>
                <td>${record.examType}</td>
                <td>${record.marks}</td>
                <td>${record.grade}</td>
                <td>
                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `
  })

  tableBody.innerHTML = html
}

function populateAttendanceList() {
  const container = document.getElementById("attendance-list-container")
  if (!container) return

  const students = [
    { id: "STU001", name: "John Smith" },
    { id: "STU002", name: "Emily Johnson" },
    { id: "STU003", name: "Michael Brown" },
    { id: "STU004", name: "Jessica Davis" },
    { id: "STU005", name: "David Wilson" },
    { id: "STU006", name: "Sarah Martinez" },
    { id: "STU007", name: "James Taylor" },
    { id: "STU008", name: "Jennifer Anderson" },
  ]

  let html = ""
  students.forEach((student) => {
    html += `
            <div class="attendance-item">
                <div class="attendance-item-name">${student.name} (${student.id})</div>
                <div class="attendance-status">
                    <label><input type="radio" name="attendance-${student.id}" value="present" checked> Present</label>
                    <label><input type="radio" name="attendance-${student.id}" value="absent"> Absent</label>
                    <label><input type="radio" name="attendance-${student.id}" value="late"> Late</label>
                </div>
            </div>
        `
  })

  container.innerHTML = html
}

function populateGradeList() {
  const container = document.getElementById("grade-list-container")
  if (!container) return

  const students = [
    { id: "STU001", name: "John Smith" },
    { id: "STU002", name: "Emily Johnson" },
    { id: "STU003", name: "Michael Brown" },
    { id: "STU004", name: "Jessica Davis" },
    { id: "STU005", name: "David Wilson" },
    { id: "STU006", name: "Sarah Martinez" },
    { id: "STU007", name: "James Taylor" },
    { id: "STU008", name: "Jennifer Anderson" },
  ]

  let html = ""
  students.forEach((student) => {
    html += `
            <div class="grade-item">
                <div class="grade-item-name">${student.name} (${student.id})</div>
                <div class="grade-input">
                    <label>Marks: <input type="number" name="grade-${student.id}" min="0" max="100" value="0"></label>
                </div>
            </div>
        `
  })

  container.innerHTML = html
}

function addCourseToGrid() {
  const courseGrid = document.getElementById("course-grid")
  if (!courseGrid) return

  const courseName = document.getElementById("course-name").value || "New Course"
  const courseCode = document.getElementById("course-code").value || "CODE101"
  const courseType = document.getElementById("course-type").value || "Core"
  const courseDepartment = document.getElementById("course-department").value || "Department"
  const courseCredits = document.getElementById("course-credits").value || "3"
  const courseCapacity = document.getElementById("course-capacity").value || "30"

  const courseCard = document.createElement("div")
  courseCard.className = "course-card"
  courseCard.innerHTML = `
        <div class="course-header">
            <h4>${courseName}</h4>
            <p>${courseCode}</p>
        </div>
        <div class="course-body">
            <div class="course-info">
                <p>Department: <span>${courseDepartment}</span></p>
                <p>Type: <span>${courseType}</span></p>
                <p>Credits: <span>${courseCredits}</span></p>
                <p>Capacity: <span>${courseCapacity}</span></p>
            </div>
            <div class="course-actions">
                <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                <button class="action-btn delete"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    `

  courseGrid.prepend(courseCard)
}

function addAttendanceRecord() {
  const tableBody = document.getElementById("attendance-table-body")
  if (!tableBody) return

  const className = document.getElementById("attendance-class").value || "Class"
  const date = document.getElementById("attendance-date").value || new Date().toISOString().split("T")[0]

  // In a real application, you would calculate these values
  const present = Math.floor(Math.random() * 10) + 20 // Random number between 20-30
  const absent = Math.floor(Math.random() * 5) + 1 // Random number between 1-5
  const total = present + absent
  const percentage = Math.round((present / total) * 100) + "%"

  const row = document.createElement("tr")
  row.innerHTML = `
        <td>${className}</td>
        <td>${date}</td>
        <td>${present}</td>
        <td>${absent}</td>
        <td>${percentage}</td>
        <td>Admin User</td>
        <td>
            <button class="action-btn edit"><i class="fas fa-edit"></i></button>
            <button class="action-btn view"><i class="fas fa-eye"></i></button>
            <button class="action-btn delete"><i class="fas fa-trash"></i></button>
        </td>
    `

  tableBody.prepend(row)
}

function addGradeRecord() {
  const tableBody = document.getElementById("grade-table-body")
  if (!tableBody) return

  const className = document.getElementById("grade-class").value || "Class"
  const subject = document.getElementById("grade-subject").value || "Subject"
  const examType = document.getElementById("grade-exam").value || "Exam"

  // Get a random student
  const students = [
    { id: "STU001", name: "John Smith" },
    { id: "STU002", name: "Emily Johnson" },
    { id: "STU003", name: "Michael Brown" },
    { id: "STU004", name: "Jessica Davis" },
  ]

  const randomStudent = students[Math.floor(Math.random() * students.length)]
  const marks = Math.floor(Math.random() * 30) + 70 // Random number between 70-100

  let grade
  if (marks >= 90) grade = "A+"
  else if (marks >= 80) grade = "A"
  else if (marks >= 70) grade = "B+"
  else if (marks >= 60) grade = "B"
  else grade = "C"

  const row = document.createElement("tr")
  row.innerHTML = `
        <td>${randomStudent.id}</td>
        <td>${randomStudent.name}</td>
        <td>${className}</td>
        <td>${subject}</td>
        <td>${examType}</td>
        <td>${marks}</td>
        <td>${grade}</td>
        <td>
            <button class="action-btn edit"><i class="fas fa-edit"></i></button>
            <button class="action-btn view"><i class="fas fa-eye"></i></button>
            <button class="action-btn delete"><i class="fas fa-trash"></i></button>
        </td>
    `

  tableBody.prepend(row)
}

