const $ = selector => document.querySelector(selector);
export function showError(message = '') { $('#api-error').textContent = message; $('#api-error').hidden = !message; }
export function showLoading() { $('#loading').hidden = false; $('#collection').setAttribute('aria-busy','true'); }
export function hideLoading() { $('#loading').hidden = true; $('#collection').setAttribute('aria-busy','false'); }
export function renderBooks(books, {onEdit, onDelete, searching = false, busy = false} = {}) {
  $('#book-list').replaceChildren();
  $('#book-count').textContent = `${books.length} 冊`;
  $('#empty').hidden = books.length !== 0;
  $('#empty').textContent = searching ? '検索に一致する本がありません。' : '本がありません。「本を追加」から登録してください。';
  for (const book of books) {
    const card = document.createElement('li');
    card.className = 'rounded-xl border border-stone-200 bg-white p-6 flex flex-col';
    for (const [tag, value] of [['p',book.genre],['h3',book.title],['p',book.author],['p',`${book.year}年`]]) {
      const element = document.createElement(tag); element.textContent = value;
      element.className = 'mt-2 break-words'; card.append(element);
    }
    for (const [label, action] of [['編集',onEdit],['削除',onDelete]]) {
      const button = document.createElement('button'); button.type = 'button';
      button.textContent = label; button.className = 'mt-4 underline self-start';
      button.setAttribute('aria-label', `${book.title}を${label}`); button.disabled = busy;
      button.addEventListener('click', () => action(book)); card.append(button);
    }
    $('#book-list').append(card);
  }
}
