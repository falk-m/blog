---
title: 'url safe encoding'
taxonomy:
    tag:
        - PHP
date: '09-12-2023'
---

```
protected function urlSafeBase64Decode(string $data)
    {
        $value = \base64_decode(\strtr($data, '-_', '+/'));
      
        $data = \json_decode($value);
        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new Exception('JSON failed');
        }

        return $data;
    }

    protected function urlSafeBase64Encode(mixed $data): string
    {
        $data = \json_encode($data, \JSON_UNESCAPED_SLASHES);
        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new Exception('JSON failed');
        }

        return \rtrim(\strtr(\base64_encode($data), '+/', '-_'), '=');
    }
```

Why do use the JSON_UNESCAPED_SLASHES option? Normally, "/" is escaped to "\\/". but instead of transmitting the raw json string, we encode them also base64. so we don't need the double encoding of the slash character.