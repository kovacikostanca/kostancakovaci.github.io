// Optional: function to open project (not needed if you use <a href>)
function openProject(url) {
  window.location.href = url;
}

// Filtering functionality
const filterButtons = document.querySelectorAll('.filter-btn');
const projects = document.querySelectorAll('.project-card');

filterButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    // Highlight active button
    filterButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const filter = btn.dataset.filter;

    projects.forEach(project => {
      // Check if project category includes filter
      if (filter === 'all' || project.dataset.category.includes(filter)) {
        project.style.display = 'block';
      } else {
        project.style.display = 'none';
      }
    });
  });
});


// Make service cards clickable
const serviceCards = document.querySelectorAll('.service-card');

serviceCards.forEach((card, index) => {
  card.addEventListener('click', () => {
    // Open the corresponding service page in the ../services/ folder
    window.location.href = `../services/service${index + 1}.html`;
  });
});

