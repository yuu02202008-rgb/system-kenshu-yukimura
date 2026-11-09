"use strict";
// 第4週: DOM操作のみ。DB/APIとの接続は第5週に追加する。
let books = [
  {id: 1, title: "星の王子さま", author: "サン＝テグジュペリ", year: 1943, genre: "児童文学"},
  {id: 2, title: "坊っちゃん", author: "夏目漱石", year: 1906, genre: "小説"},
  {id: 3, title: "銀河鉄道の夜", author: "宮沢賢治", year: 1934, genre: "小説"}
];
let nextId = 4;
const list = document.querySelector("#book-list");
const form = document.querySelector("#book-form");
const toggle = document.querySelector("#add-button");
const fields = ["title", "author", "year", "genre"];
const notice = document.querySelector("#notice");
function textElement(tag, text, classes) {
  const element = document.createElement(tag);
  element.textContent = text; // 入力をHTMLとして実行しない。
  element.className = classes;
  return element;
}
function renderBooks() {
  list.replaceChildren();
  document.querySelector("#book-count").textContent = `${books.length} 冊`;
  document.querySelector("#empty").hidden = books.length !== 0;
  books.forEach(book => {
    const card = document.createElement("li");
    card.className = "rounded-xl border border-stone-200 bg-white p-6 flex flex-col";
    card.append(textElement("p", book.genre, "text-xs font-semibold text-teal-700"));
    card.append(textElement("h3", book.title, "mt-4 text-xl font-bold break-words"));
    card.append(textElement("p", book.author, "mt-2 text-sm text-slate-600 break-words"));
    card.append(textElement("p", `${book.year}年`, "mt-2 text-sm text-slate-500"));
    const remove = textElement("button", "削除", "mt-6 self-start text-sm text-slate-500 underline hover:text-red-700");
    remove.type = "button";
    remove.setAttribute("aria-label", `${book.title}を削除`);
    remove.addEventListener("click", () => {
      books = books.filter(item => item.id !== book.id);
      renderBooks();
      notice.textContent = `${book.title}を画面から削除しました。`;
      toggle.focus();
    });
    card.append(remove);
    list.append(card);
  });
}
toggle.addEventListener("click", () => {
  form.hidden = !form.hidden;
  toggle.setAttribute("aria-expanded", String(!form.hidden));
  if (!form.hidden) form.elements.title.focus();
});
form.addEventListener("submit", event => {
  event.preventDefault();
  const values = {};
  let firstInvalid = null;
  fields.forEach(name => {
    const input = form.elements.namedItem(name);
    values[name] = input.value.trim();
    let error = values[name] === "" ? "入力してください。" : "";
    if (!error && name === "year" && (!/^\d{1,4}$/.test(values[name]))) {
      error = "0〜9999の整数を入力してください。";
    }
    if (!error && input.maxLength > 0 && values[name].length > input.maxLength) error = "文字数が上限を超えています。";
    input.setAttribute("aria-invalid", String(Boolean(error)));
    document.querySelector(`#${name}-error`).textContent = error;
    if (error && !firstInvalid) firstInvalid = input;
  });
  if (firstInvalid) { firstInvalid.focus(); return; }
  const book = {...values, year: Number(values.year)};
  console.log(book);
  console.log(JSON.stringify(book));
  books.push({id: nextId++, ...book});
  renderBooks();
  form.reset();
  notice.textContent = `${book.title}を画面に追加しました。`;
});
renderBooks();
