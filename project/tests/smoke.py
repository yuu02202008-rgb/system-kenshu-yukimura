"""Run the Week 1 and 2 HTTP checks against the local Docker Compose app."""

import json
import time
from urllib.error import HTTPError, URLError
from urllib.parse import urlencode
from urllib.request import Request, urlopen


BASE = "http://127.0.0.1:8000"
FORM_BASE = "http://127.0.0.1:8001"


def request(url, method="GET", body=None, content_type=None):
    headers = {"Content-Type": content_type} if content_type else {}
    req = Request(url, data=body, headers=headers, method=method)
    try:
        with urlopen(req, timeout=10) as response:
            return response.status, response.read(), response.headers
    except HTTPError as error:
        return error.code, error.read(), error.headers


def check_json(path, expected_status, method="GET", payload=None):
    body = json.dumps(payload).encode("utf-8") if payload is not None else None
    status, raw, headers = request(
        BASE + path,
        method,
        body,
        "application/json" if body is not None else None,
    )
    assert status == expected_status, (method, path, status, raw.decode("utf-8"))
    assert "application/json" in headers.get("Content-Type", ""), (method, path, headers)
    result = json.loads(raw)
    print(f"{method} {path}: {status}")
    return result


def main():
    status, html, _ = request(BASE + "/")
    assert status == 200 and "Book Library" in html.decode("utf-8")
    assert "星の王子さま" in html.decode("utf-8")

    assert check_json("/api/status.php", 200)["status"] == "ok"
    books = check_json("/api/books-get.php", 200)["data"]
    assert len(books) == 3, books
    first_book = check_json("/api/books-get.php?id=1", 200)["data"]
    assert first_book["title"] == "星の王子さま", first_book
    assert check_json("/api/books-get.php?id=999999", 404)["error"] == "Book not found."
    check_json("/api/books-get.php?id=0", 400)
    check_json("/api/books-create.php", 400, "POST", {"author": "Yuki", "year": 2026})
    check_json("/api/books-create.php", 405)

    created = check_json(
        "/api/books-create.php",
        201,
        "POST",
        {"title": "CI Test Book", "author": "Yuki", "year": 2026, "genre": "Study"},
    )
    book_id = created["id"]
    assert isinstance(book_id, int) and book_id > 0
    assert check_json(f"/api/books-get.php?id={book_id}", 200)["data"]["title"] == "CI Test Book"
    updated = check_json(
        "/api/books-update.php",
        200,
        "PUT",
        {"id": book_id, "title": "Updated CI Test Book"},
    )
    assert updated["data"]["title"] == "Updated CI Test Book"
    assert check_json(f"/api/books-get.php?id={book_id}", 200)["data"]["title"] == "Updated CI Test Book"
    assert check_json(f"/api/books-delete.php?id={book_id}", 200, "DELETE")["deleted_id"] == book_id
    check_json(f"/api/books-get.php?id={book_id}", 404)

    for attempt in range(20):
        try:
            status, _, _ = request(FORM_BASE + "/post-form.php")
            assert status == 200
            break
        except URLError:
            if attempt == 19:
                raise
            time.sleep(0.25)
    form = urlencode({"name": "<script>"}).encode("utf-8")
    status, html, _ = request(
        FORM_BASE + "/post-form.php", "POST", form, "application/x-www-form-urlencoded"
    )
    text = html.decode("utf-8")
    assert status == 200 and "&lt;script&gt;" in text and "<script>" not in text
    print("Week 1 form: GET and POST passed")
    print("All Week 1 and 2 runtime checks passed")


if __name__ == "__main__":
    main()
