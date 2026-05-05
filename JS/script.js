// ── MAMA-KHALU.COM — Main Application Logic ──

// ── Data Store ──
const store = {
  jobs: [
    { id: 1, title: 'Frontend Developer', company: 'TechCorp', location: 'Remote', salary: '$80k - $120k', type: 'Full-time', skills: ['React', 'CSS', 'JavaScript'], rating: 4.8, reviews: 120, match: 95, applicants: 45 },
    { id: 2, title: 'Backend Engineer', company: 'DataSystems', location: 'New York, NY', salary: '$100k - $140k', type: 'Full-time', skills: ['Node.js', 'Python', 'SQL'], rating: 4.5, reviews: 85, match: 88, applicants: 32 },
    { id: 3, title: 'UI/UX Designer', company: 'CreativeStudio', location: 'Remote', salary: '$70k - $100k', type: 'Contract', skills: ['Figma', 'Prototyping', 'User Research'], rating: 4.9, reviews: 200, match: 70, applicants: 28 },
    { id: 4, title: 'Full Stack Developer', company: 'WebFlow Inc.', location: 'San Francisco, CA', salary: '$110k - $150k', type: 'Full-time', skills: ['React', 'Node.js', 'MongoDB'], rating: 4.7, reviews: 95, match: 82, applicants: 51 },
    { id: 5, title: 'DevOps Engineer', company: 'CloudBase', location: 'Remote', salary: '$90k - $130k', type: 'Full-time', skills: ['Docker', 'AWS', 'CI/CD'], rating: 4.6, reviews: 73, match: 75, applicants: 19 },
    { id: 6, title: 'Mobile Developer', company: 'AppCraft', location: 'Austin, TX', salary: '$85k - $125k', type: 'Full-time', skills: ['React Native', 'Swift', 'Firebase'], rating: 4.4, reviews: 60, match: 68, applicants: 37 }
  ],

  exams: {
    1: [
      { q: 'What does the "useState" hook return in React?', a: 'A state variable and a function to update it', b: 'Only a state variable', c: 'A reference to a DOM element', d: 'A callback function', correct: 'a' },
      { q: 'Which CSS property is used to create flexible layouts?', a: 'float', b: 'position', c: 'display: flex', d: 'overflow', correct: 'c' },
      { q: 'What is the correct syntax to add an event listener in JavaScript?', a: 'element.listen("click", fn)', b: 'element.addEventListener("click", fn)', c: 'element.on("click", fn)', d: 'element.event("click", fn)', correct: 'b' },
      { q: 'Which HTML5 element is used for navigation links?', a: '<navigation>', b: '<menu>', c: '<nav>', d: '<links>', correct: 'c' },
      { q: 'What does "===" mean in JavaScript?', a: 'Assignment', b: 'Loose equality', c: 'Strict equality (value + type)', d: 'Not equal', correct: 'c' }
    ],
    2: [
      { q: 'Which Node.js module is used to create an HTTP server?', a: 'fs', b: 'http', c: 'path', d: 'url', correct: 'b' },
      { q: 'What does SQL stand for?', a: 'Structured Query Language', b: 'Simple Query Logic', c: 'Standard Query Library', d: 'Server Query Language', correct: 'a' },
      { q: 'In Python, which keyword is used to define a function?', a: 'function', b: 'fn', c: 'define', d: 'def', correct: 'd' },
      { q: 'What is a REST API?', a: 'A database system', b: 'A stateless client-server architecture', c: 'A frontend framework', d: 'A CSS library', correct: 'b' },
      { q: 'Which HTTP method is used to update a resource?', a: 'GET', b: 'POST', c: 'PUT', d: 'DELETE', correct: 'c' }
    ],
    3: [
      { q: 'What is the primary purpose of a wireframe?', a: 'To write code', b: 'To outline layout and structure', c: 'To choose colors', d: 'To deploy a website', correct: 'b' },
      { q: 'Which tool is most commonly used for UI design in 2026?', a: 'Photoshop', b: 'Paint', c: 'Figma', d: 'PowerPoint', correct: 'c' },
      { q: 'What does UX stand for?', a: 'User Extension', b: 'User Experience', c: 'Universal Export', d: 'Unified Exchange', correct: 'b' },
      { q: 'What is a design system?', a: 'A coding framework', b: 'A collection of reusable components and guidelines', c: 'A type of database', d: 'A deployment tool', correct: 'b' },
      { q: 'Which principle focuses on making content easy to scan?', a: 'Affordance', b: 'Visual hierarchy', c: 'Elasticity', d: 'Recursion', correct: 'b' }
    ],
    4: [
      { q: 'What does MERN stack stand for?', a: 'MongoDB, Express, React, Node', b: 'MySQL, Express, Ruby, Node', c: 'MongoDB, Ember, React, Nginx', d: 'MySQL, Express, React, Nginx', correct: 'a' },
      { q: 'Which database is document-oriented?', a: 'PostgreSQL', b: 'MySQL', c: 'MongoDB', d: 'SQLite', correct: 'c' },
      { q: 'What is middleware in Express.js?', a: 'A database query', b: 'A function that runs between request and response', c: 'A CSS framework', d: 'A testing library', correct: 'b' },
      { q: 'What does "npm" stand for?', a: 'Node Package Manager', b: 'New Project Module', c: 'Node Process Monitor', d: 'Network Protocol Manager', correct: 'a' },
      { q: 'Which React hook handles side effects?', a: 'useState', b: 'useRef', c: 'useEffect', d: 'useMemo', correct: 'c' }
    ],
    5: [
      { q: 'What is Docker used for?', a: 'Writing CSS', b: 'Containerizing applications', c: 'Managing databases', d: 'Designing UIs', correct: 'b' },
      { q: 'What does CI/CD stand for?', a: 'Code Integration / Code Deployment', b: 'Continuous Integration / Continuous Delivery', c: 'Central Interface / Central Design', d: 'Clean Import / Clean Data', correct: 'b' },
      { q: 'Which AWS service provides serverless computing?', a: 'EC2', b: 'S3', c: 'Lambda', d: 'RDS', correct: 'c' },
      { q: 'What is Kubernetes?', a: 'A programming language', b: 'A container orchestration platform', c: 'A CSS framework', d: 'A code editor', correct: 'b' },
      { q: 'What does "Infrastructure as Code" mean?', a: 'Writing HTML', b: 'Managing infrastructure through code and automation', c: 'Designing databases', d: 'Building APIs', correct: 'b' }
    ],
    6: [
      { q: 'What language is used for iOS development?', a: 'Java', b: 'Kotlin', c: 'Swift', d: 'Dart', correct: 'c' },
      { q: 'What is React Native?', a: 'A CSS library', b: 'A framework for building native mobile apps with JavaScript', c: 'A database', d: 'An operating system', correct: 'b' },
      { q: 'Which service provides real-time database for mobile apps?', a: 'GitHub', b: 'Firebase', c: 'Heroku', d: 'Netlify', correct: 'b' },
      { q: 'What is the purpose of an emulator in mobile development?', a: 'To write code faster', b: 'To simulate a mobile device for testing', c: 'To deploy apps', d: 'To design icons', correct: 'b' },
      { q: 'Which file format is used for app distribution on Android?', a: '.exe', b: '.ipa', c: '.apk', d: '.dmg', correct: 'c' }
    ]
  },

  user: {
    name: 'John Doe',
    email: 'john.doe@example.com',
    applications: [
      { jobId: 1, status: 'Interviewing', score: 92, time: '2 days ago' },
      { jobId: 3, status: 'Pending Review', score: 88, time: '5 days ago' }
    ],
    passedExams: [1, 3],
    failedExams: [],
    courses: []
  }
};

// ── Page Router ──
document.addEventListener('DOMContentLoaded', () => {
  const page = window.location.pathname.split('/').pop() || 'index.html';

  // Mobile menu toggle
  const toggle = document.querySelector('.menu-toggle');
  const navLinks = document.querySelector('.nav-links');
  if (toggle && navLinks) {
    toggle.addEventListener('click', () => navLinks.classList.toggle('open'));
  }

  // Page init
  switch (page) {
    case 'jobs.html': renderJobs(); break;
    case 'job-detail.html': renderJobDetail(); break;
    case 'exam.html': initExam(); break;
    case 'exam-result.html': renderExamResult(); break;
    case 'dashboard.html': renderDashboard(); break;
  }
});

// ── Jobs Page ──
function renderJobs() {
  const list = document.getElementById('job-list');
  if (!list) return;
  list.innerHTML = '';

  store.jobs.forEach(job => {
    const card = document.createElement('div');
    card.className = 'glass-card slide-up';
    card.innerHTML = `
      <div class="flex-between mb-2">
        <span class="badge">${job.match}% Match</span>
        <span class="text-muted text-sm">★ ${job.rating} (${job.reviews})</span>
      </div>
      <h3 class="mb-1">${job.title}</h3>
      <p class="text-muted mb-2 text-sm">${job.company} · ${job.location}</p>
      <div class="mb-3">${job.skills.map(s => `<span class="tag">${s}</span>`).join('')}</div>
      <div class="flex-between">
        <strong class="text-primary">${job.salary}</strong>
        <a href="job-detail.html?id=${job.id}" class="btn btn-primary">View Job</a>
      </div>
    `;
    list.appendChild(card);
  });
}

// ── Job Detail Page ──
function renderJobDetail() {
  const id = parseInt(new URLSearchParams(window.location.search).get('id')) || 1;
  const job = store.jobs.find(j => j.id === id);
  if (!job) return;

  setText('job-title', job.title);
  setText('job-company', job.company);
  setText('job-salary', job.salary);
  setText('job-location', `${job.type} · ${job.location}`);
  setText('job-applicants', `${job.applicants} applicants`);

  const skillsEl = document.getElementById('job-skills');
  if (skillsEl) skillsEl.innerHTML = job.skills.map(s => `<span class="tag">${s}</span>`).join('');

  const examBtn = document.getElementById('take-exam-btn');
  if (examBtn) examBtn.href = `exam.html?id=${job.id}`;

  // Company initial
  const icon = document.getElementById('company-icon');
  if (icon) icon.textContent = job.company.charAt(0);
}

// ── Exam System ──
let examState = { current: 0, score: 0, answers: [], questions: [], jobId: 1 };

function initExam() {
  const id = parseInt(new URLSearchParams(window.location.search).get('id')) || 1;
  const questions = store.exams[id];
  if (!questions) {
    document.getElementById('question-text').textContent = 'No exam found for this job.';
    return;
  }

  examState = { current: 0, score: 0, answers: [], questions, jobId: id };

  // Show job name
  const job = store.jobs.find(j => j.id === id);
  const jobLabel = document.getElementById('exam-job-name');
  if (jobLabel && job) jobLabel.textContent = job.title;

  loadQuestion();
}

function loadQuestion() {
  const { current, questions } = examState;
  const q = questions[current];
  const total = questions.length;

  // Update text
  setText('question-num', `Question ${current + 1}`);
  setText('question-total', `of ${total}`);
  setText('question-text', q.q);

  // Update progress
  const bar = document.getElementById('progress-bar');
  if (bar) bar.style.width = `${((current + 1) / total) * 100}%`;

  // Build options
  const container = document.getElementById('options-container');
  container.innerHTML = '';

  ['a', 'b', 'c', 'd'].forEach((key, idx) => {
    const btn = document.createElement('button');
    btn.className = 'option-btn';
    btn.innerHTML = `<span class="option-letter">${key.toUpperCase()}</span><span class="option-text">${q[key]}</span>`;
    btn.onclick = () => selectAnswer(key, btn);
    container.appendChild(btn);
  });

  // Update pagination dots
  updatePagination();
}

function selectAnswer(key, btn) {
  const { current, questions } = examState;
  const correct = questions[current].correct;

  // Disable all buttons
  document.querySelectorAll('.option-btn').forEach(b => {
    b.disabled = true;
    b.classList.add('disabled');
  });

  // Show correct / wrong
  if (key === correct) {
    btn.classList.add('correct');
    examState.score++;
  } else {
    btn.classList.add('wrong');
    // Highlight the correct one
    const allBtns = document.querySelectorAll('.option-btn');
    ['a','b','c','d'].forEach((k, i) => {
      if (k === correct) allBtns[i].classList.add('correct');
    });
  }

  examState.answers.push(key);

  // Move to next after delay
  setTimeout(() => {
    if (current < questions.length - 1) {
      examState.current++;
      loadQuestion();
    } else {
      // Exam finished
      const percent = Math.round((examState.score / questions.length) * 100);
      localStorage.setItem('lastExamScore', percent);
      localStorage.setItem('lastExamJobId', examState.jobId);
      window.location.href = 'exam-result.html';
    }
  }, 800);
}

function updatePagination() {
  const dots = document.getElementById('pagination-dots');
  if (!dots) return;
  dots.innerHTML = '';
  examState.questions.forEach((_, i) => {
    const dot = document.createElement('span');
    dot.className = 'page-dot';
    if (i < examState.current) dot.classList.add('done');
    if (i === examState.current) dot.classList.add('active');
    dots.appendChild(dot);
  });
}

// ── Exam Result ──
function renderExamResult() {
  const score = parseInt(localStorage.getItem('lastExamScore')) || 0;
  const jobId = parseInt(localStorage.getItem('lastExamJobId')) || 1;
  const job = store.jobs.find(j => j.id === jobId);
  const passed = score >= 80;

  setText('result-score', `${score}%`);
  setText('result-job', job ? job.title : 'Assessment');

  const icon = document.getElementById('result-icon');
  const title = document.getElementById('result-title');
  const msg = document.getElementById('result-msg');
  const action = document.getElementById('result-action');
  const circle = document.getElementById('score-circle');

  if (passed) {
    icon.textContent = '🎉';
    title.textContent = 'Congratulations! You Passed!';
    msg.textContent = 'You scored above the 80% threshold. You can now submit your application.';
    action.innerHTML = '<a href="apply.html" class="btn btn-primary w-full">Proceed to Application →</a>';
    if (circle) circle.classList.add('pass');
  } else {
    icon.textContent = '📚';
    title.textContent = 'Keep Going! You Can Do Better.';
    msg.textContent = `You need 80% to pass. We have assigned a skill-building course to help you improve.`;
    action.innerHTML = '<a href="courses.html" class="btn btn-primary w-full">Start Assigned Course →</a>';
    if (circle) circle.classList.add('fail');
  }
}

// ── Dashboard ──
function renderDashboard() {
  setText('user-name', store.user.name);
}

// ── Utility ──
function setText(id, text) {
  const el = document.getElementById(id);
  if (el) el.textContent = text;
}
