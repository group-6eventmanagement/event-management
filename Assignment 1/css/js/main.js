// js/main.js
document.addEventListener('DOMContentLoaded', () => {
  const search = document.getElementById('search');
  const filter = document.getElementById('filter');
  const eventList = document.getElementById('eventList');
  if (!search || !filter || !eventList) return;

  const events = eventList.querySelectorAll('.event-card');

  function filterEvents() {
    const searchText = search.value.toLowerCase();
    const category = filter.value;

    events.forEach(event => {
      const title = (event.querySelector('h3')?.textContent || '').toLowerCase();
      const eventCategory = event.getAttribute('data-category') || '';

      if ((category === 'all' || eventCategory === category) && title.includes(searchText)) {
        event.style.display = 'block';
      } else {
        event.style.display = 'none';
      }
    });
  }

  search.addEventListener('keyup', filterEvents);
  filter.addEventListener('change', filterEvents);
});