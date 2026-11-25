import {getBooks, createBook, updateBook, deleteBook} from './api.js';
import {renderBooks, showError, showLoading, hideLoading} from './ui.js';
const $ = s => document.querySelector(s);
const form = $('#book-form');
const fields = ['title','author','year','genre'];
let books = [], editingId = null, busy = false, loaded = false;
function render() {
  const query = $('#search').value.trim().toLocaleLowerCase();
  renderBooks(books.filter(b => `${b.title} ${b.author}`.toLocaleLowerCase().includes(query)),
    {onEdit: edit, onDelete: remove, searching: Boolean(query), busy});
  if (!loaded) $('#empty').hidden = true;
}
function reset() {
  editingId = null; form.reset(); form.hidden = true;
  $('#add-button').setAttribute('aria-expanded','false');
  for (const name of fields) { $(`#${name}-error`).textContent = ''; form.elements.namedItem(name).removeAttribute('aria-invalid'); }
}
function openForm(book) {
  reset(); editingId = book?.id ?? null; form.hidden = false;
  $('#add-button').setAttribute('aria-expanded','true');
  $('#form-heading').textContent = book ? '本を編集' : '新しい本を追加';
  form.querySelector('[type="submit"]').textContent = book ? '変更を保存' : 'コレクションに追加';
  if (book) for (const name of fields) form.elements.namedItem(name).value = book[name];
  form.elements.namedItem('title').focus();
}
async function run(action) {
  if (busy) return;
  busy = true; showError(); showLoading();
  document.querySelectorAll('#book-form input, #book-form button, #add-button, #retry').forEach(e => e.disabled = true); render();
  try { await action(); } catch (error) { showError(error.message); }
  finally { busy = false; hideLoading(); document.querySelectorAll('#book-form input, #book-form button, #add-button, #retry').forEach(e => e.disabled = false); render(); }
}
function edit(book) { if (!busy) openForm(book); }
function remove(book) { return run(async () => {
  await deleteBook(book.id); books = books.filter(b => b.id !== book.id);
  if (editingId === book.id) reset();
  $('#notice').textContent = `${book.title}を削除しました。`;
}); }
async function load() { await run(async () => { books = await getBooks(); loaded = true; }); $('#retry').hidden = loaded; }
$('#add-button').addEventListener('click', () => form.hidden || editingId !== null ? openForm() : reset());
$('#cancel-edit').addEventListener('click', reset);
$('#retry').addEventListener('click', load);
$('#search').addEventListener('input', render); // 取得済みの配列を絞り込む。APIを再度呼ばない。
form.addEventListener('submit', event => {
  event.preventDefault(); if (busy) return;
  const values = {}; let firstInvalid;
  for (const name of fields) {
    const input = form.elements.namedItem(name); values[name] = input.value.trim();
    let error = !values[name] ? '入力してください。' : '';
    if (!error && name === 'year' && !/^\d{1,4}$/.test(values[name])) error = '0〜9999の整数を入力してください。';
    if (!error && name !== 'year' && [...values[name]].length > (name === 'genre' ? 100 : 255)) error = '文字数が上限を超えています。';
    $(`#${name}-error`).textContent = error; input.setAttribute('aria-invalid', String(Boolean(error)));
    if (error && !firstInvalid) firstInvalid = input;
  }
  if (firstInvalid) { firstInvalid.focus(); return; }
  values.year = Number(values.year);
  run(async () => {
    const updated = editingId === null ? await createBook(values) : await updateBook({...values, id: editingId});
    books = editingId === null ? [...books, updated] : books.map(b => b.id === editingId ? updated : b);
    loaded = true; $('#retry').hidden = true;
    $('#notice').textContent = `${updated.title}を保存しました。`; reset();
  });
});
load();
