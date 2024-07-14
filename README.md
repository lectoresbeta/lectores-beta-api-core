<table align="center">
    <tr style="text-align: center;">
        <td align="center" width="9999">
            <img src="./.etc/logo.png" width="200" alt="Project icon" style="margin:0; padding: 0; display: inline-block">

<h1 style="margin: 0; padding: 0; color: black;">Lectores Beta - Core API</h1>
</td>
</tr>
</table>

# Setup :gear:

## 1. Install Dependencies :hammer:

```shell
make start
```

## 2. Discover another useful commands :mag_right:

```shell
make show-containers   List all our active containers
make start             Start and run project
make start/force       Start and run project forcing container contextual rebuild
make stop              Stop project
make install           Install dependencies
make package/add       Install new package through composer
make bash              Enter to the php-fpm container
make unit              Run unitary tests suite
make style/all         Analyse code style and possible errors
make style/code-style  Analyse code style
make style/fix         Fix code style
```

# Request Flow :arrows_counterclockwise:

![Common application request flow layer by layer](.etc/flow.png)

# Links :link:

## :link: [Project structure :file_folder:](.etc/how-to/PROJECT_STRUCTURE.md)
## :link: [Working agreements :handshake:](.etc/how-to/WORKING_AGREEMENTS.md)
## :link: [Configure on windows :windows_conf:](.etc/how-to/CONFIGURE_ON_WINDOWS.md)