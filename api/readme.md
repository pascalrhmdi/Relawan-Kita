Api documentation for relawan kita

Endpoints & params
- Activity :
1. [GET] /api/activity/all.php?start=0&amount=3 `get all activity with limit`
2. [GET] /api/activity/show.php?id=1 `get details for single activity`
3. [POST] /api/activity/register.php `register to become volunteer`
   > body : userId & eventId
4. [GET] /api/activity/category.php  `get all activity categories`
5. [GET] /api/activity/search.php?key=1&start=0&amount=3  `search activity`

- Volunteer :
1. [POST] /api/volunteer/store.php  `register new volunteer`
   > body : email, password, nama, alamat, nomor_telepon, jenis_kelamin, tanggal_lahir
2. [POST] /api/volunteer/login.php `/login new volunteer`
   > body : email, password
3. [GET] /api/volunteer/show.php?id=1 `get relawan user data`
4. [POST] /api/volunteer/update.php?id=1 `update volunteer user data`
   > body : nama, alamat, nomor_telepon, jenis_kelamin, tanggal_lahir
5. [GET] /api/volunteer/history.php?id=1&start=0&amount=3 `get user volunteer registration history`
