# TaskFlux – Mock Auth + Task CRUD

A full-stack assignment with a **Laravel API** and **Vue 3** frontend.

## Live URLs
- API: http://localhost:8000/api
- Frontend: https://localhost:5173
- OpenAPI spec: http://localhost:8000/docs

## Tech Choices & Design Decisions
- **Mock Auth**: Simple bearer token to focus on API behavior; still uses middleware to simulate protected routes.
- **MongoDB**: Fits flexible task schema; `mongodb/laravel-mongodb` Eloquent-like API keeps code idiomatic.
- **Filtering/Sorting/Pagination**: Meets real-world needs; sort syntax `-field` for desc, `field` for asc.
- **Validation & Errors**: Laravel FormRequests return 422 with field messages; 404 on missing resources; 401 on missing/invalid token.
- **Testing**: Feature tests cover login and CRUD happy-path.
- **Indexes**: Compound index supports common filters + date sort; single-field + text index for broader queries. See `db/indexes.js`.

## Run The API Locally
```bash
git clone https://github.com/Azzam279/taskflux-api.git
```
```bash
cd taskflux-api
```
```bash
composer install
```
```bash
cp env.example .env
```
edit Mongo and MOCK_TOKEN
```bash
php artisan key:generate
```
```bash
php artisan serve
```

## Run Unit Test
```bash
php artisan test
```

or if using Docker
```bash
docker compose exec app php artisan test
```
