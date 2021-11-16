Api documentation for relawan kita

Endpoints & params
- Activity :
1. [GET] /api/activity?start={start}&amount={amount} `get all activity with limit`
2. [GET] /api/activity/{activity_id} `get details for single activity`
3. [POST] /api/activity/register `register to become volunteer`
   > body : userId & eventId
4. [GET] /api/activity/category  `get all activity categories`
5. [GET] /api/activity/search/{keyword}?start={start}&amount={amount}  `search activity with limit`

- Volunteer :
1. [POST] /api/volunteer/register  `register new volunteer`
   > body : email, password, nama, alamat, nomor_telepon, jenis_kelamin, tanggal_lahir
2. [POST] /api/volunteer/login `login for volunteer`
   > body : email, password
3. [GET] /api/volunteer/profile/{user_id} `get volunteer user data`
4. [PUT] /api/volunteer/profile/{user_id} `update volunteer user data`
   > body : nama, alamat, nomor_telepon, jenis_kelamin, tanggal_lahir
5. [PUT] /api/volunteer/change-password `change account password`
   > body : userId, password, password_baru, password_verifikasi
6. [GET] /api/volunteer/history/{user_id}?start={start}&amount={amount} `get user volunteer registration history with limit`
