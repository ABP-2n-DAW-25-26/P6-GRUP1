# P6-GRUP1
Developer tools to install on your computer <br>
[![Node.js](https://img.shields.io/badge/Node.js-339933?logo=nodedotjs&logoColor=white)](https://nodejs.org/)
[![Composer](https://img.shields.io/badge/Composer-885630?logo=composer&logoColor=white)](https://getcomposer.org/)
[![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)](https://www.docker.com/)
## Project setup instructions
Add .env file from .env.example
```bash
cp .env.example .env
```
Install packages
```bash
composer run setup
```
Run the project
```bash
composer run dev
```
## Other useful commands
Run tests
```bash
composer run test
```
Check formatting without modifying files
```bash
composer run lint:check
```
Format code
```bash
composer run lint
```
Run CI checks locally
```bash
composer run ci:check
```
Build frontend assets
```bash
npm run build
```