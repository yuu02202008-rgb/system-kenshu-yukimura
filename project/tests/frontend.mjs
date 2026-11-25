// 実際のHTTP APIに接続して、DOMの操作結果とDBの永続化を検証する。
import {JSDOM} from 'jsdom';
import {readFile} from 'node:fs/promises';
import vm from 'node:vm';
import assert from 'node:assert/strict';
const base = 'http://127.0.0.1:8000';
const dom = new JSDOM(await readFile('project/frontend/index.html','utf8'), {url:base,runScripts:'outside-only'});
const {window:w} = dom; const d = w.document;
let requests=0, offline=false, gate;
w.AbortSignal = AbortSignal;
w.fetch = async (url, options) => {requests++; if(offline) throw new Error('offline'); if(gate) await gate; return fetch(new URL(url,base),options);};
const context=dom.getInternalVMContext(); const modules=new Map();
async function moduleFor(name) {
  if(modules.has(name)) return modules.get(name);
  const mod=new vm.SourceTextModule(await readFile(`project/frontend/assets/js/${name}`,'utf8'), {context,identifier:name});
  modules.set(name,mod); await mod.link(specifier=>moduleFor(specifier.replace('./',''))); return mod;
}
await (await moduleFor('app.js')).evaluate();
async function until(test) {for(let i=0;i<250;i++){if(test())return;await new Promise(r=>setTimeout(r,20));}throw new Error('Timed out: '+test);}
const $=s=>d.querySelector(s);
const idle=()=>$('#loading').hidden;
const clickText=text=>[...d.querySelectorAll('button')].find(b=>b.getAttribute('aria-label')===text).click();
await until(idle); assert.equal(d.querySelectorAll('#book-list li').length,3);
$('#search').value='夏目'; const before=requests; $('#search').dispatchEvent(new w.Event('input')); assert.equal(d.querySelectorAll('#book-list li').length,1);assert.equal(requests,before);
$('#search').value='';$('#search').dispatchEvent(new w.Event('input'));
$('#add-button').click();$('#book-form').dispatchEvent(new w.Event('submit',{cancelable:true}));assert.equal(d.querySelectorAll('[aria-invalid="true"]').length,4);
const title='<img src=x onerror=alert(1)> integration';
function fill(values){for(const [k,v]of Object.entries(values))$('#book-form').elements.namedItem(k).value=v;}
fill({title,author:'CI',year:'2026',genre:'test'});
let release; gate=new Promise(r=>release=r);
$('#book-form').dispatchEvent(new w.Event('submit',{cancelable:true}));assert.equal(idle(),false);assert.equal($('#book-form button[type="submit"]').disabled,true);release();gate=null;
await until(idle);assert.equal(d.querySelectorAll('#book-list li').length,4);assert.equal($('#book-list img'),null);assert.equal($('#title').value,'');
let saved=(await (await fetch(base+'/api/books')).json()).data.find(b=>b.title===title);assert.ok(saved);
clickText(title+'を編集');assert.equal($('#title').value,title);fill({title:'Updated integration'});$('#book-form').dispatchEvent(new w.Event('submit',{cancelable:true}));await until(idle);
assert.equal((await(await fetch(base+'/api/books?id='+saved.id)).json()).data.title,'Updated integration');
offline=true;clickText('Updated integrationを削除');await until(idle);assert.equal($('#api-error').hidden,false);assert.equal(d.querySelectorAll('#book-list li').length,4);
offline=false;clickText('Updated integrationを削除');await until(idle);assert.equal(d.querySelectorAll('#book-list li').length,3);assert.equal((await fetch(base+'/api/books?id='+saved.id)).status,404);
$('#search').value='no matches 999';$('#search').dispatchEvent(new w.Event('input'));assert.equal($('#empty').hidden,false);
// 空の配列も実際のレンダラーで確認（既存DBの本は削除しない）。
modules.get('ui.js').namespace.renderBooks([],{});assert.equal($('#empty').hidden,false);assert.match($('#empty').textContent,/本がありません/);
assert.ok(d.querySelector('link[rel="icon"]')); console.log('PASS: real API load/create/update/delete, validation, persistence, search/no extra fetch, loading, failed delete retention, XSS text, empty state');dom.window.close();
