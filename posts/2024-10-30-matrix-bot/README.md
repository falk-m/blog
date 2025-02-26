---
title: 'Matrix Bot'
taxonomy:
    tag:
        - Other
date: '2024-10-30'
---

I consider writing a bot for listing all new messages from a specific matrix room.

## Get access token

[Link to documentation](https://matrix.org/docs/older/client-server-api/)

List login methods of the matrix server:

```bash
curl -XGET "https://matrix.eigenbaukombinat.de/_matrix/client/r0/login"
```

Response: 

```json
{
    "flows":[
        {"type":"m.login.password"},
        {"type":"m.login.application_service"}
    ]
}
```

If "m.login.password" is included, then request an access token.

```bash
curl -XPOST "https://matrix.eigenbaukombinat.de/_matrix/client/r0/login" \
-d '{"type":"m.login.password", "user":"xxx", "password":"xxx"}'
```

Response: 

```json
{
    "user_id":"@xxx:matrix.eigenbaukombinat.de",
    "access_token":"token_token_token",
    "home_server":"matrix.eigenbaukombinat.de",
    "device_id":"HJUHNZMDGM",
    "well_known":{"m.homeserver":{"base_url":"https://matrix.eigenbaukombinat.de/"}}
}
```

## list rooms

[Link to documentation](https://spec.matrix.org/legacy/client_server/r0.2.0.html#get-matrix-client-r0-publicrooms)

To receive the room ID I use the endpoint so list the public rooms of the server.

```bash
curl -XGET "https://matrix.eigenbaukombinat.de/_matrix/client/r0/publicRooms?access_token=token_token_token"
```

Response: 

```json
{
  "chunk": [
    {
      "room_id": "!DRJjBzEuQGkqJhhETA:matrix.eigenbaukombinat.de",
      "name": "ank\\u00fcndigungen",
      "topic": "Ank\\u00fcndigung von vereinsweiten Terminen / Veranstaltungen / Arbeitseins\\u00e4tzen und -treffen und sonstigen wichtigen bereichs\\u00fcbergreifenden Informationen.",
      "canonical_alias": "#ankuendigungen:matrix.eigenbaukombinat.de",
      "num_joined_members": 197,
      "avatar_url": "mxc://matrix.eigenbaukombinat.de/LYADmhdSfWhWlEuaLupJAJWK",
      "world_readable": true,
      "guest_can_join": false,
      "join_rule": "public"
    },
    {
      "room_id": "!LDygbFxIVtzvvzbIpf:matrix.eigenbaukombinat.de",
      "name": "sozialraum",
      "topic": "Raum f\\u00fcr alle und alles - Orgatreffen-Pad - https://pads.eigenbaukombinat.de/EBK-Orgatreffen ",
      "canonical_alias": "#sozialraum:matrix.eigenbaukombinat.de",
      "num_joined_members": 189,
      "avatar_url": "mxc://matrix.eigenbaukombinat.de/JbtIkSniratWEafDEzhILhTG",
      "world_readable": false,
      "guest_can_join": false,
      "join_rule": "public"
    }
  ]
}
```

## get room messages

[Link to documentation](https://spec.matrix.org/legacy/client_server/r0.2.0.html#get-matrix-client-r0-rooms-roomid-messages)

Request messages from newest to oldest (dir=b)

```bash
curl -XGET "https://matrix.eigenbaukombinat.de/_matrix/client/r0/rooms/%21DRJjBzEuQGkqJhhETA%3Amatrix.eigenbaukombinat.de/messages?dir=b&access_token=token_token_token"
```

Response: 

```json
{
  "chunk": [
    {
      "content": {
        "displayname": "cc_22",
        "membership": "join"
      },
      "event_id": "$172977849013444jsAAJ:matrix.org",
      "origin_server_ts": 1729778490915,
      "room_id": "!DRJjBzEuQGkqJhhETA:matrix.eigenbaukombinat.de",
      "sender": "@cc_22:matrix.org",
      "state_key": "@cc_22:matrix.org",
      "type": "m.room.member",
      "unsigned": {
        "membership": "join"
      },
      "user_id": "@cc_22:matrix.org"
    },
    {
      "type": "m.room.message",
      "room_id": "!DRJjBzEuQGkqJhhETA:matrix.eigenbaukombinat.de",
      "sender": "@xxx:matrix.eigenbaukombinat.de",
      "content": {
        "msgtype": "m.text",
        "body": "Am Freitag, dem 18. Oktober 2024, findet ab ca. 19 Uhr der n\\u00e4chste Koch- und Kennenlernabend statt. Wir werden wieder gemeinsam kochen,, und wie traditionell im Oktober, machen wir irgendwas mit K\\u00fcrbis. Wenn ihr teilnehmen, etwas mitbringen oder Rezeptideen einbringen wollt, dann tragt Euch bitte bis Donnerstag im Pad ein: https://pads.eigenbaukombinat.de/SoPv9f96S_SD-0v0Lg62Kw?both#",
        "m.mentions": {}
      },
      "event_id": "$17290141291033ajgSt:matrix.eigenbaukombinat.de",
      "origin_server_ts": 1729014129678,
      "unsigned": {
        "membership": "join",
        "age": 1280945657
      },
      "user_id": "@xxx:matrix.eigenbaukombinat.de",
      "age": 1280945657
    },
    {
      "type": "m.room.message",
      "room_id": "!LDygbFxIVtzvvzbIpf:matrix.eigenbaukombinat.de",
      "sender": "@xxx:matrix.eigenbaukombinat.de",
      "content": {
        "msgtype": "m.text",
        "body": "@room Anmeldung f\\u00fcr Blenderkurs 2024 er\\u00f6ffnet:\nhttps://eigenbaukombinat.de/kurs-blender-2024/"
      },
      "origin_server_ts": 1730220187066,
      "unsigned": {
        "membership": "join",
        "age": 75229291
      },
      "event_id": "$LkcZ0F8sJHlxLIHSkRZz1nqR9llQQ-4a1ezjJ8A5xF8",
      "user_id": "@xxx:matrix.eigenbaukombinat.de",
      "age": 75229291
    },
  ],
  "start": "t533-4979861_0_0_0_0_0_0_0_0_0",
  "end": "t524-4752862_0_0_0_0_0_0_0_0_0"
}
```