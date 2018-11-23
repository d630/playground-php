## How to register?

```sh
# *nickname* must be alpha-numeric
# *password* may contain only: alpha-numrics and !#$%&'*+-=?^_`{|}~@.[]

curl -v -s -L -b /tmp/corg-cookie.txt -c /tmp/corg-cookie.txt \
    -X PUT 'http://localhost:8080/auth' \
    -H 'Accept: application/json' \
    -H 'Content-Type: application/json'
    --data '{
        "nickname": "foo",
        "password": 1234,
        "password2": 1234
    }';
```

## How to login?

```sh
curl -v -s -L -b /tmp/corg-cookie.txt -c /tmp/corg-cookie.txt \
    -X POST 'http://localhost:8080/auth' \
    -H 'Accept: application/json' \
    -H 'Content-Type: application/json'
    --data '{
        "nickname": "foo",
        "password": 1234
    }';
```

## How to logout?

```sh
curl -v -s -L -b /tmp/corg-cookie.txt -c /tmp/corg-cookie.txt \
    -X DELETE 'http://localhost:8080/auth' \
    -H "Accept: application/json";
```

## How to create a file entry?

At first upload a file:

```sh
curl -v -s
    -X POST 'http://localhost:8080/files' \
    -H 'Accept: application/json' \
    -H 'Content-Type: multipart/form-data' \
    -F 'uploaded_file=@-' <<< 'i am a text file';
```

You will get a JSON response like:

```json
{
  "uploaded_file": {
    "name": "-",
    "type": "text/plain",
    "tmp_name": ".CorglMc2ef",
    "error": 0,
    "size": 17
  }
}
```

Then take `tmp_name`, rename the file, if you want, and make a second POST request:

```sh
curl -v -s -L -b /tmp/corg-cookie.txt -c /tmp/corg-cookie.txt
    -X POST 'http://localhost:8080/files'
    -H 'Accept: application/json'
    -H 'Content-Type: application/json'
    --data '{
        "tmp_name": ".CorglMc2ef",
        "size": 17,
        "mtype": "text/plain",
        "name": "my-new-file-name",
        "description": "say something about me",
        "employee_id": 1
    }';
```

## How to download a file?

```sh
curl -v -L -b /tmp/corg-cookie.txt -c /tmp/corg-cookie.txt \
    'http://localhost:8080/files/1?alt=media' \
    -H "Accept: application/json";
```
