<p align="center"><img src="https://sibers.com/images/logo.png" alt="Sibers API"></p>

Sibers API (based by API Platform) is a next-generation web framework designed to easily create API-first projects without
compromising extensibility and flexibility:

* Design your own data model as plain old PHP classes or import an existing one from the [Schema.org](https://schema.org/) vocabulary
* **Expose in minutes a hypermedia REST API** with pagination, data validation, access control, relation embedding, filters and error handling...
* Benefit from Content Negotiation: [JSON-LD](http://json-ld.org), [Hydra](http://hydra-cg.com), [HAL](http://stateless.co/hal_specification.html), [YAML](http://yaml.org/), [JSON](http://www.json.org/), [XML](https://www.w3.org/XML/) and [CSV](https://www.ietf.org/rfc/rfc4180.txt) are supported out of the box
* Enjoy the **beautiful automatically generated API documentation** (Swagger/OpenAPI)
* Add [**a convenient Material Design administration interface**](https://github.com/api-platform/admin) built with [React](https://facebook.github.io/react/) without writing a line of code
* **Scaffold a fully functional Single-Page-Application** built with [React](https://facebook.github.io/react/), [Redux](http://redux.js.org/), [React Router](https://reacttraining.com/react-router/) and [Bootstrap](https://getbootstrap.com/) thanks to [the CRUD generator](github.com/api-platform/generate-crud)
* Install a development environment and deploy your project in production using **[Docker](https://docker.com)**
* Easily add **[JSON Web Token](https://jwt.io/) or [OAuth](https://oauth.net/) authentication**
* Create specs and tests with a **developer friendly API testing tool** on top
  of [Behat](http://behat.org/)


Sibers API embraces open web standards (Swagger, JSON-LD, Hydra, HAL, JWT, OAuth,
HTTP...) and the [Linked Data](https://www.w3.org/standards/semanticweb/data) movement. Your API will automatically
expose structured data in Schema.org/JSON-LD. It means that your API Platform application
is usable **out of the box** with technologies of the semantic
web.

It also means that **your SEO will be improved** because **[Google leverages these
formats](https://developers.google.com/structured-data/)**.

Last but not least, Sibers API is built on top of the [Symfony](https://symfony.com) framework.
It means than you can:

* use **thousands of Symfony bundles** with API Platform
* integrate API Platform in **any existing Symfony application**
* reuse **all your Symfony skills** and benefit of the incredible
  amount of Symfony documentation
* enjoy the popular [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html) (used by default, but fully optional: you can
  use the data provider you want, including but not limited to MongoDB ODM and ElasticSearch)

Install
-------

Run **composer require sibers/sibers-api-bundle**. After installation required generation SSH keys.

$ mkdir -p var/jwt # For Symfony3+, no need of the -p option  
$ openssl genrsa -out var/jwt/private.pem -aes256 4096  
$ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem  

Configure your parameters.yml

jwt_private_key_path: '%kernel.root_dir%/../var/jwt/private.pem' # ssh private key path  
jwt_public_key_path:  '%kernel.root_dir%/../var/jwt/public.pem'  # ssh public key path  
jwt_key_pass_phrase:  ''                                         # ssh key pass phrase  
jwt_token_ttl:        3600  

Credits
-------

Created by Alexander Gordeychik.