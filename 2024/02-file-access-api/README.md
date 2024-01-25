---
title: 'store and play video files from the local file system'
taxonomy:
    tag:
        - js
date: '24-01-2024'
---

For one of my next projects, I have to cache large files locally on the device to use them also in offline mode. 

When I stored the files on the local file system, then they were not addicted to the browser cache and could not be deleted by mistake. 

You can use the [file system API](https://developer.mozilla.org/en-US/docs/Web/API/File_System_API) to select a local directory for this or you can use the [StorageManager](https://developer.mozilla.org/en-US/docs/Web/API/StorageManager/getDirectory) to store the data in the [origin private file system (opfs)](https://developer.mozilla.org/en-US/docs/Web/API/File_System_API/Origin_private_file_system)

For my test, I chose the opfs.
First, you need a directory handler object:
```js
let directoryHandler = null;

navigator.storage.getDirectory().then((dh) => {
    directoryHandler = dh;
});
```

Then you can create a new file in this directory:
```js 
const fileHandle = await directoryHandler.getFileHandle(
    "video_file",
    {
        create: true,
    }
);
```

The result is a file handle.
If you use an input field to upload a file, you have to convert the file to an array buffer, then you can write dies in the new local file. 

```js
var file = e.currentTarget.files[0];

reader = new FileReader();

reader.onloadend = async (e) => {
    const writable = await fileHandle.createWritable();
    await writable.write(e.target.result);
    await writable.close();
};

reader.readAsArrayBuffer(file);
```

The filehandle can also be used to play the video from the local storage:
```js
const file = await fileHandle.getFile();
const videoElement = document.getElementById("video");
const url = URL.createObjectURL(file);
videoElement.src = url;
videoElement.play();
```

Later, you can iterate with the directory handler over the files in them and receive also the fileHandle:

```js
 for await (const [file_name, fileHandle] of directoryHandler.entries()) {
    const file = await fileHandle.getFile();
    const videoElement = document.getElementById("video");
    const url = URL.createObjectURL(file);
    videoElement.src = url;
    videoElement.play();
    return;
}
```