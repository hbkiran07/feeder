# feeder-demo

🚀 Demo Laravel project for feed twitter.


Example Register Request

```js
POST http://127.0.0.1:8000/api/register

Body
{
    "name":"test name",
    "surname":"test surname",
    "userName":"test",
    "email":"test@test.com.tr",
    "password":"123456789a",
    "phoneNumber":"5353353535",
    "feederPlatform":"twitter",
    "feederAddress":"test"
}

Response
{
    "success": true,
    "message": "User create successfully. Please verificate your acoount"
}
```

Example Register Fail Request

```js
POST http://127.0.0.1:8000/api/register

Body
{
    "name":"test name",
    "surname":"test surname",
    "userName":"test",
    "email":"test@test.com.tr",
    "password":"123456789a",
    "phoneNumber":"5353353535",
    "feederPlatform":"twitter",
    "feederAddress":"test"
}

Response
{
    "success": false,
    "message": "This email address already in use."
}
```

Example Success Verificate With SMS

```js
POST http://127.0.0.1:8000/api/verificate/sms

Body
{
    "userName":"test",
    "verificationCode":"590d3e9a"
}

Response
{
    "success": true,
    "message": "Account successfully verification with SMS."
}
```

Example Fail Verificate With SMS

```js
POST http://127.0.0.1:8000/api/verificate/sms

Body
{
    "userName":"test",
    "verificationCode":"eb3a12ee"
}

Response
{
    "success": false,
    "message": "Check username or verification code."
}
```

Example Success Verificate With Email

```js
POST http://127.0.0.1:8000/api/verificate/email

Body
{
    "email":"test@test.com.tr",
    "verificationCode":"3e99737a0f93ec91b00d82aa3f6fd16c"
}

Response
{
    "success": true,
    "message": "Account successfully verification with Email."
}
```

Example Fail Verificate With Email

```js
POST http://127.0.0.1:8000/api/verificate/sms

Body
{
    "email":"test@test.com.tr",
    "verificationCode":"bf0ca3281ce8bf36603740a5d4ec46aa"
}

Response
{
    "success": false,
    "message": "Check email or verification code."
}
```


Example Success Login

```js
POST http://127.0.0.1:8000/api/login

Body
{
    "userName":"bob",
    "password":"123456789a"
}

Response
{
    "success": true,
    "message": "Login successfully.",
    "token": "7bc6473a0e0ab31fc2d09f66d30f3406"
}
```

Example Fail Login

```js
POST http://127.0.0.1:8000/api/login

Body
{
    "userName":"bob",
    "password":"123456789a"
}

Response
{
    "success": false,
    "message": "Check username or password."
}
```

Example Success Activate Feed

```js
POST http://127.0.0.1:8000/api/feed/activate

Body
{
    "feedId":"73"
}

Response
{
    "success": true,
    "message": "Feeds successfully activated."
}
```

Example Fail Activate Feed

```js
POST http://127.0.0.1:8000/api/feed/activate

Body
{
    "feedId":"93"
}

Response
{
    "success": false,
    "message": "No such data was found."
}
```

Example Success Edit Feed

```js
POST http://127.0.0.1:8000/api/feed/edit

Body
{
    "feedId":"77",
    "value":"lorem ipsun ipsum lorem."
}

Response
{
    "success": true,
    "message": "Feeds successfully edited."
}
```

Example Fail Edit Feed

```js
POST http://127.0.0.1:8000/api/feed/edit

Body
{
    "feedId":"15",
    "value":"lorem ipsun ipsum lorem."
}

Response
{
    "success": false,
    "message": "No such data was found."
}
```

Example Success Get Active Feeds

```js
GET http://127.0.0.1:8000/api/feed/active

Response
{
    "success": true,
    "message": "Feeds successfully listed.",
    "data": [
        {
            "id": 73,
            "user_name": "test",
            "data": "He desires to paint you the dreamiest, shadiest, quietest, most enchanting bit of romantic landscape in all the valleyof the Saco.",
            "status": 1
        },
        {
            "id": 74,
            "user_name": "test",
            "data": "No, when I go to sea, I go as a simple sailor, right before the mast,plumb down into the forecastle, aloft there to the royal mast-head.",
            "status": 1
        },
        {
            "id": 75,
            "user_name": "test",
            "data": "Tell me, does the magnetic virtue of the needles of the compasses of all those ships attract them thither?",
            "status": 1
        }
    ]
}
```

Example Fail Get Active Feeds

```js
GET http://127.0.0.1:8000/api/feed/active

Response
{
    "success": false,
    "message": "Unexpected Error."
}
```

Example Success Get Passive Feeds

```js
GET http://127.0.0.1:8000/api/feed/passive

Response
{
    "success": true,
    "message": "Feeds successfully listed.",
    "data": [
        {
            "id": 71,
            "user_name": "test",
            "data": "It is a way I have of driving off the spleen and regulating the circulation.",
            "status": 0
        },
        {
            "id": 72,
            "user_name": "test",
            "data": "For as in this world,head winds are far more prevalent than winds from astern (that is, ifyou never violate the Pythagorean maxim), so for the most part theCommodore on the quarter-deck gets his atmosphere at second hand fromthe sailors on the forecastle.",
            "status": 0
        },

    ]
}
```

Example Fail Get Passive Feeds

```js
GET http://127.0.0.1:8000/api/feed/passive

Response
{
    "success": false,
    "message": "Unexpected Error."
}
```

Example Success Get All Feeds

```js
GET http://127.0.0.1:8000/api/feed/all

Response
{
    "success": true,
    "message": "Feeds successfully listed.",
    "data": [
        {
            "id": 71,
            "user_name": "test",
            "data": "It is a way I have of driving off the spleen and regulating the circulation.",
            "status": 0
        },
        {
            "id": 73,
            "user_name": "test",
            "data": "He desires to paint you the dreamiest, shadiest, quietest, most enchanting bit of romantic landscape in all the valleyof the Saco.",
            "status": 1
        }
    ]
}
```

Example Fail Get All Feeds

```js
GET http://127.0.0.1:8000/api/feed/all

Response
{
    "success": false,
    "message": "Unexpected Error."
}
```

Example Success Different User All Feeds

```js
GET http://127.0.0.1:8000/api/feed/user?username=bob

Response
{
    "success": true,
    "message": "Feeds successfully listed.",
    "data": [
        {
            "user_name": "bob",
            "data": "He desires to paint you the dreamiest, shadiest, quietest, most enchanting bit of romantic landscape in all the valleyof the Saco."
        },
        {
            "user_name": "bob",
            "data": "No, when I go to sea, I go as a simple sailor, right before the mast,plumb down into the forecastle, aloft there to the royal mast-head."
        }
    ]
}
```

Example Fail Different User All Feeds

```js
GET http://127.0.0.1:8000/api/feed/user?username=bob

Response
{
    "success": false,
    "message": "Unexpected Error."
}
```

Example Success All Feeds All User

```js
GET http://127.0.0.1:8000/api/feed/flow?page=1

Response
{
    "success": true,
    "message": "Feeds successfully listed.",
    "data": [
        {
            "user_name": "bob",
            "data": "He desires to paint you the dreamiest, shadiest, quietest, most enchanting bit of romantic landscape in all the valleyof the Saco."
        },
        {
            "user_name": "test",
            "data": "Tell me, does the magnetic virtue of the needles of the compasses of all those ships attract them thither?"
        }
    ]
}
```

Example Success All Feeds All User

```js
GET http://127.0.0.1:8000/api/feed/user?username=bob

Response
{
    "success": false,
    "message": "Unexpected Error."
}
```
