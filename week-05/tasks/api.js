const endpoint = 'https://jsonplaceholder.typicode.com/posts';
function decode(response) { if (!response.ok) throw new Error(`HTTP ${response.status}`); return response.json(); }
// then: Promiseの結果を次の関数へ渡す。
export function fetchPostsPromise() { return fetch(endpoint + '?_limit=10').then(decode); }
// await: Promiseが完了するまでこのasync関数の続きを待つ。画面全体は止めない。
export async function fetchPosts() { const response = await fetch(endpoint + '?_limit=10'); return await decode(response); }
export async function createPost(post) { return await decode(await fetch(endpoint, {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(post)})); }
