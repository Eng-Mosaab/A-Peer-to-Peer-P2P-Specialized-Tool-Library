document.addEventListener('DOMContentLoaded', () => {
  const markButtons = document.querySelectorAll('.mark-read-btn');
  markButtons.forEach(btn => {
    btn.addEventListener('click', async () => {
      const id = btn.dataset.id;
      const body = new URLSearchParams({ id });
      const res = await fetch(`${window.BASE_URL}?page=notifications&action=markRead`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body
      });
      const data = await res.json();
      if (data.success) window.location.reload();
    });
  });

  const searchForm = document.querySelector('.ajax-search-form');
  if (searchForm) {
    searchForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const q = document.getElementById('toolSearchInput').value || '';
      const res = await fetch(`${window.BASE_URL}?page=tools&action=search&search=${encodeURIComponent(q)}`);
      const data = await res.json();
      const tbody = document.querySelector('#toolsTable tbody');
      if (!tbody) return;
      tbody.innerHTML = '';
      if (!data.items.length) {
        tbody.innerHTML = '<tr><td colspan="6">No data yet.</td></tr>';
        return;
      }
      data.items.forEach(tool => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${tool.id}</td>
          <td>${tool.name}</td>
          <td>${tool.category_name}</td>
          <td><span class="badge">${tool.status}</span></td>
          <td>${tool.lender_name}</td>
          <td class="table-actions"><a href="${window.BASE_URL}?page=tools&action=show&id=${tool.id}">Details</a></td>
        `;
        tbody.appendChild(row);
      });
    });
  }
});
