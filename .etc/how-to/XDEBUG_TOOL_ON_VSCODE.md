# ALL DO YOU NEED
For this project all is ready to use "xdebug", all do you need is to install VSCode extensions, build a "launch.json" file, and that's all.
#### VSCode extensións for PHP
- PHP Debug (xdebug.org)

#### launch.json file
Basically there are three abailable ways, but i've using the firts one <strong>"Listen for Xdebug"</strong>. When you run the tool for the first time, you will be asked to build the <strong>"launch.json"</strong> file. You must select the <strong>"PHP"</strong> option and after that, add the <strong>"pathMappings"</strong> element to the json file.

Run "Listen for Xdebug", add your breakpoints, go to the browser, search for a URL  for example "/system/healthcheck" and it must work.

Enjoy!!
```
{
    // Use IntelliSense to learn about possible attributes.
    // Hover to view descriptions of existing attributes.
    // For more information, visit: https://go.microsoft.com/fwlink/?linkid=830387
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}",
            }
        },
        {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 0,
            "runtimeArgs": [
                "-dxdebug.start_with_request=yes"
            ],
            "env": {
                "XDEBUG_MODE": "debug,develop",
                "XDEBUG_CONFIG": "client_port=${port}"
            }
        },
        {
            "name": "Launch Built-in web server",
            "type": "php",
            "request": "launch",
            "runtimeArgs": [
                "-dxdebug.mode=debug",
                "-dxdebug.start_with_request=yes",
                "-S",
                "localhost:0"
            ],
            "program": "",
            "cwd": "${workspaceRoot}",
            "port": 9003,
            "serverReadyAction": {
                "pattern": "Development Server \\(http://localhost:([0-9]+)\\) started",
                "uriFormat": "http://localhost:%s",
                "action": "openExternally"
            }
        }
    ]
}
```