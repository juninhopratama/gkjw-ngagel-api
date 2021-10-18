<h1 align="center">GKJW Ngagel Booking System API</h3>

## 📝 About the Project

This project aims to automize Ibadah Minggu booking process by introducing a web-based app to be used by every Jemaat GKJW Ngagel who are planning to have an onsite Ibadah. You can read the <a href="https://foremost-silene-d2b.notion.site/PRD-GKJW-Ngagel-Booking-System-47d0196902bb430eab426db3b27fa962">PRD here</a>.

## 📦 About this Repository

This repository is for the backend system which provides the APIs to be consumed by the frontend. This backend system is built using <a href="https://laravel.com">Laravel</a>.

## 🍴 Consumable APIs

To consume API, you can hit it using this URL
```sh
https://domain/api

example
https://domain/api/ibadah
```

### 🎯 API Endpoints

- **GET**
    ```sh
    /ibadah
    /ibadah/{id}
    /registration
    /registration/{id}
    ```
    Response Example for /ibadah
    ```json
    {
    "data": [
        {
            "id": 2,
            "tanggal_ibadah": "2021-10-31",
            "nama_ibadah": "Ibadah minggu biasa 31",
            "quota": 95,
            "created_at": "2021-10-17T17:26:09.000000Z",
            "updated_at": "2021-10-17T17:42:11.000000Z"
        }
    ],
    "message": "Retrieved Successfully"
    }
    ```
    Response Example for /registration
    ```json
    {
    "data": {
        "id": 7,
        "uuid": "142ee22c-a144-44e2-977f-df0257d6032f",
        "nama_jemaat": "Ezra Juninho Pratama",
        "nik": "1404514022",
        "id_ibadah": "1",
        "date_registered": "2021-10-18 14:15:30",
        "wilayah": "3",
        "kelompok": "5",
        "gereja_asal": "GKJW Ngagel",
        "isScanned": false,
        "created_at": "2021-10-18T14:15:30.000000Z",
        "updated_at": "2021-10-18T14:20:34.000000Z"
    },
    "message": "Retrieved Successfully"
    }
    ```
- **POST**
    ```sh
    /ibadah
    /registration
    ```
    #### Payload ####
    Payload for POST method in ```/ibadah```
    Variable | Data Type | Nullable
    | --- | --- | --- |
    nama_ibadah | String | NULL
    tanggal_ibadah | Date (yyyy-mm-dd) | NOT NULL
    quota | Integer | NOT NULL
    
    Payload for POST method in ```/registration```
    Variable | Data Type | Nullable
    | --- | --- | --- |
    nama_jemaat | String | NOT NULL
    nik | String | NOT NULL
    id_ibadah | Integer | NOT NULL
    wilayah | Integer | NULL if gereja_asal is NOT NULL
    kelompok | Integer | NULL if gereja_asal is NOT NULL
    gereja_asal | String | NULL if wilayah and kelompok is NOT NULL

## 🧑‍🔧 Contributing

I am open to any inputs for this system. You can contact me to discuss more.

## 🧑‍💻 Author

API for GKJW Ngagel Booking System is developed by <a href="https://www.linkedin.com/in/ezrajuninho/">**Ezra Juninho Pratama**</a> using Laravel Framework. I hope we can serve God through technology:)
