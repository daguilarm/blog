---
extends: _layouts.post
section: content
title: Sistemas de gestión de servidores
date: 2019-12-21
description: Listado de los principales sistemas de gestión de servidores.
categories: [servidores]
---


El objectivo de este artículo es el de mantener una lista (actualizada) de los principales sistemas de gestión de servidores. 

Los servicios analizados (22/12/2019) son:

+ [Laravel forge](https://forge.laravel.com/){.link-out}
+ [Moss](https://moss.sh/){.link-out}
+ [Runcloud](https://runcloud.io/){.link-out}
+ [ServerPilot](https://serverpilot.io/){.link-out}

### Sus características

| Servicio | SSL gratis | Bases datos   | Workers | Supervisor | Redis |
|:---      |:---        |:---           |:---     |:---        |:---   |
| Forge    | Si         | Si            | Si      | Si         | Si    |
| Moss     | Si         | Si            | Si      | Si         | Si    |
| Runcloud | Si         | Si            | --      | Si         | Si    |
| ServerP  | Si         | Si            | --      | --         | --    |

### Tipo de plan

| Servicio   | Plan grauito   | Planes de pago (mes)  |
|:---        | :---           | :---                  |
| Forge      | 5 días prueba  | 9$    - 19$   - 49$   |
| Moss       | Si             | 12$   - 19$   - 39$   |
| Runcloud   | Si             | 6.67$ - 12.5$ - 37.5$ |
| ServerP(*) | Modo de prueba | 5$    - 10$   - 20$   |

(*) Tienen un coste adicional por cada aplicación configurada.

### Servicios de deploy 

| Servicio | Github | Bitbucket | GitLab | Custom Git |
|:---      |:---    |:---       |:---    |:---        |
| Forge    | Si     | Si        | Si     | Si         |
| Moss     | Si     | Si        | Si     | Si         |
| Runcloud | Si     | Si        | Si     | Si         |
| ServerP  | --     | --        | --     | --         |

### Servidores soportados

| Servicio | Digital(*) | Linode | Amazon | Vultr | Upcloud | Google | Custom |
|:---      |:---        |:---    |:---    |:---   |:---     |:---    |:---    |
| Forge    | Si         | Si     | Si     | Si    |--       |--      |Si      |
| Moss     | Si         | --     | Si     | Si    |Si       |Si      |Si      |
| Runcloud | Si         | Si     | --     | --    |--       |--      |--      |
| ServerP  | Si         | Si     | Si     | Si    |--       |--      |Si      |

(*)Digitalocean

<div class="border border-blue-300 rounded bg-blue-100 shadow-lg p-4">
    Si conoces y has utilizado más servicios para la gestión de servidores, ves algún error, o falta algo... hazmelo saber!
</div>
