// 通信だけを担当。HTTPの失敗とネットワーク切断の両方を呼び出し元へ伝える。
async function request(method, data, id) {
  const url = '/api/books' + (id == null ? '' : `?id=${encodeURIComponent(id)}`);
  let response;
  try { response = await fetch(url, {method, headers: {'Content-Type':'application/json'},
    ...(data === undefined ? {} : {body: JSON.stringify(data)}), signal: AbortSignal.timeout(15000)}); }
  catch { throw new Error('通信できません。接続を確認して、もう一度お試しください。'); }
  let body;
  try { body = await response.json(); } catch { throw new Error('サーバーの応答を読み取れません。'); }
  if (!response.ok) throw new Error([body.error || `HTTP ${response.status}`, ...Object.values(body.details || {})].join(' '));
  return body;
}
export const getBooks = async () => (await request('GET')).data;
export const createBook = async book => (await request('POST', book)).data;
export const updateBook = async book => (await request('PUT', book)).data;
export const deleteBook = id => request('DELETE', undefined, id);
