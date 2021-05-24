# Getting Started with food api

## Getting Started

### Introduction

Food Api = 1.0.0
This is a first version of the Food API
It is an commertial applicatiobn

### Installation

The following section explains how to use the food apiLib library in a new project.

### Initialize the API Client

The following parameters are configurable for the API Client:

| Parameter | Type | Description |
|  --- | --- | --- |
| `authorization` | `string` | *Default*: `'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6NTAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYxNjg1MDE4OCwiZXhwIjoxNjE2OTM2NTg4LCJuYmYiOjE2MTY4NTAxODgsImp0aSI6IlVHZ0h3SUFvaTNVSWlTMmoiLCJzdWIiOjUzLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.0R75IpG92siFIUM3AEMgzlwGm79vM--YuERu2T-f6Cs'` |
| `timeout` | `number` | Timeout for API calls.<br>*Default*: `0` |
| `accessToken` | `string` | The OAuth 2.0 Access Token to use for API requests. |

The API client can be initialized as follows:

```ts
const client = new Client({
  authorization: Liquid error: Unknown operator ey,
  timeout: 0,
  accessToken: 'AccessToken',
})
```

### Authorization

This API uses `OAuth 2 Bearer token`.

### API Errors

Here is the list of errors that the API might throw.

| HTTP Status Code | Error Description | Exception Class |
|  --- | --- | --- |
| 400 | Bad Request | `ApiError` |
| 401 | You are UnAuthorized | `ApiError` |
| 500 | Internal Server Error | `ApiError` |

## Client Class Documentation

### food api Client

The gateway for the SDK. This class acts as a factory for the Controllers and also holds the configuration of the SDK.

### Controllers

| Name | Description |
|  --- | --- |
| auth | Gets AuthController |
| product | Gets ProductController |
| order | Gets OrderController |
| review | Gets ReviewController |
| message | Gets MessageController |
| admin | Gets AdminController |
| misc | Gets MiscController |

## API Reference

### List of APIs

* [Auth](#auth)
* [Product](#product)
* [Order](#order)
* [Review](#review)
* [Message](#message)
* [Admin](#admin)
* [Misc](#misc)

### Auth

#### Logout

User must be loged in to send this request

```ts
async logout(
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
try {
  const { result, ...httpResponse } = await authController.logout();
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "message": "User logged out successfully"
}
```

#### Resendemail

to resend the email need token

:information_source: **Note** This endpoint does not require authentication.

```ts
async resendemail(
  authorization?: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `authorization` | `string \| undefined` | Header, Optional | **Default**: `'Bearer {token}'` |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const authorization = 'Bearer {token}';
try {
  const { result, ...httpResponse } = await authController.resendemail(authorization);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Forgot Password

this is sample url send to the email

http://127.0.0.1:8000/api/auth/password/reset?token=5db4496573f11cbbeab6bd7db77d4f2ae7081cf2c09f3de297889a92bd25b499&email=saifullahsaeed05%40gmail.com

:information_source: **Note** This endpoint does not require authentication.

```ts
async forgotPassword(
  email: string,
  authorization?: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<string>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `email` | `string` | Form, Required | if account exists |
| `authorization` | `string \| undefined` | Header, Optional | **Default**: `'Bearer {token}'` |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`string`

##### Example Usage

```ts
const email = 'email6';
const authorization = 'Bearer {token}';
try {
  const { result, ...httpResponse } = await authController.forgotPassword(email, authorization);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
"Email sent"
```

#### Login

Use your username and password to login

:information_source: **Note** This endpoint does not require authentication.

```ts
async login(
  body: Loginrequest,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`Loginrequest`](#loginrequest) | Body, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const body: Loginrequest = {
  username: 'user23',
  password: '1234564',
};

try {
  const { result, ...httpResponse } = await authController.login(body);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6NTAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYyMDE3NDg2NiwiZXhwIjoxNjIwMjYxMjY2LCJuYmYiOjE2MjAxNzQ4NjYsImp0aSI6Ik1pbThIUEN6YzdNQ0d5WTkiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.L7t9PXG8ogRTYBbkCFhimWIAjVMDDUspKnxJgGpIj_I",
  "token_type": "bearer",
  "token_validity": 86400
}
```

#### Resetpassword

reset password

we get token I email and email also toke and email is cross verified so don't worry if token or or mail changed it will give you an error

:information_source: **Note** This endpoint does not require authentication.

```ts
async resetpassword(
  body: Resetpasswordrequest,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`Resetpasswordrequest`](#resetpasswordrequest) | Body, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const body: Resetpasswordrequest = {
  token: '3eee3f340765df16d84d6c28dfdfa4b4e435c619e35d7b12e324dfd54a225e3d',
  email: 'saifullahsaeed05@gmail.com',
  password: 'pakistan',
};

try {
  const { result, ...httpResponse } = await authController.resetpassword(body);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Updateprofile

Takes
name
username unique
email  unique
password   at least 6 chracter
c_password

```ts
async updateprofile(
  body: Updateprofilerequest,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`Updateprofilerequest`](#updateprofilerequest) | Body, Required | Takes JSON data |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const body: Updateprofilerequest = {
  name: 'test2',
  description: 'This is my store contains this this and this ',
  typeOfBusiness: 'Restaurant',
  phone: '+923001234567',
  email: 'test3@gmail.com',
  halal: '1',
};

try {
  const { result, ...httpResponse } = await authController.updateprofile(body);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "message": "Profile Updated Secussfully",
  "errors": []
}
```

#### Emailvarify

This link you will find in the inbox of you email inbox which provided during registration

:information_source: **Note** This endpoint does not require authentication.

```ts
async emailvarify(
  token: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `token` | `string` | Template, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const token = 'token6';
try {
  const { result, ...httpResponse } = await authController.emailvarify(token);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Register

Takes
name
username unique
email  unique
password   at least 6 chracter
c_password

:information_source: **Note** This endpoint does not require authentication.

```ts
async register(
  name: string,
  username: string,
  email: string,
  password: string,
  cPassword: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `name` | `string` | Form, Required | - |
| `username` | `string` | Form, Required | Unique |
| `email` | `string` | Form, Required | Unique |
| `password` | `string` | Form, Required | at least 6 chracters |
| `cPassword` | `string` | Form, Required | same as password |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const name = 'name0';
const username = 'username0';
const email = 'email6';
const password = 'password4';
const cPassword = 'c_password0';
try {
  const { result, ...httpResponse } = await authController.register(name, username, email, password, cPassword);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "message": "Opration Secussfull",
  "user": [
    {
      "id": 3,
      "username": "saifiiw",
      "email": "saifullahsadeed05@gmail.com",
      "email_verified_at": null,
      "role": "user",
      "created_at": null,
      "updated_at": null
    }
  ]
}
```

##### Errors

| HTTP Status Code | Error Description | Exception Class |
|  --- | --- | --- |
| 400 | "error": {         "name": [             "The name field is required."         ],         "username": [             "The username field is required."         ],         "password": [             "The password field is required."         ],         "c_password": [             "The c password field is required."         ],         "email": [             "The email field is required."         ]     } } | `ApiError` |

#### Profile

profile

```ts
async profile(
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
try {
  const { result, ...httpResponse } = await authController.profile();
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "Errors": "",
  "seccuss": true,
  "User": [
    {
      "id": 1,
      "username": "user23",
      "email": "test3@gmail.com",
      "role": "user",
      "email_verified_at": null
    }
  ],
  "Profile": [
    {
      "id": 1,
      "user_id": 1,
      "name": "test2",
      "Description": "This is my store contains this this and this",
      "Type_of_Business": "Restaurant",
      "Halal": 0,
      "Varified": 0,
      "Phone": "+923001234567",
      "profile_pic": "default.png",
      "created_at": "2021-04-26 21:11:10",
      "updated_at": "2021-04-26 21:11:10"
    }
  ]
}
```

#### Profile Pic Upload

profile_pic_upload

```ts
async profilePicUpload(
  image: FileWrapper,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `image` | `FileWrapper` | Form, Required | image file |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const image = new FileWrapper(fs.createReadStream('dummy_file'));
try {
  const { result, ...httpResponse } = await authController.profilePicUpload(image);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

### Product

#### Update Ingredients

update_ingredients

```ts
async updateIngredients(
  productId: number,
  ingredients: string,
  authorization?: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `productId` | `number` | Form, Required | - |
| `ingredients` | `string` | Form, Required | - |
| `authorization` | `string \| undefined` | Header, Optional | **Default**: `'Bearer {token}'` |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const productId = 202;
const ingredients = 'ingredients4';
const authorization = 'Bearer {token}';
try {
  const { result, ...httpResponse } = await productController.updateIngredients(productId, ingredients, authorization);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Getaproduct

get a product only if its active to activate use activate handler

```ts
async getaproduct(
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
try {
  const { result, ...httpResponse } = await productController.getaproduct();
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "active": [
    {
      "product_category_item_id": 2,
      "product_category_item_name": "change name",
      "product_category_item_description": "change discription to somthing you want",
      "product_category_item_price": 25,
      "custom_order": 1,
      "active": 1,
      "list_ingredients": 0,
      "is_allergic": "[\"okqwqw\"]",
      "product_uid": "934c5023-f73c-440c-b780-8412548cec79",
      "m_delete": null,
      "product_category_id": 1,
      "product_image_id": null,
      "added_by": 1,
      "created_at": null,
      "updated_at": null,
      "id": 2,
      "image1": "product_pics/yaJpwX95wMsz8PIeoCKIf8FDLZLRSnhLm2cmrWci.jpg",
      "image2": "default.png",
      "image3": "default.png",
      "image4": "default.png",
      "image5": "default.png",
      "for_product": 2,
      "created_by": 1
    }
  ],
  "Reviews": [
    {
      "review": 5,
      "comment": "Nice Food and vary clean setup blah blah",
      "created_by": 1,
      "created_at": "2021-05-16 18:17:21"
    },
    {
      "review": 5,
      "comment": "Nice Food and vary clean setup blah blah2",
      "created_by": 1,
      "created_at": "2021-05-16 18:17:22"
    }
  ]
}
```

#### Activate Switch

activate_switch

```ts
async activateSwitch(
  body: ActivateSwitchRequest,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`ActivateSwitchRequest`](#activate-switch-request) | Body, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const body: ActivateSwitchRequest = {
  productId: 2,
  switch: true,
};

try {
  const { result, ...httpResponse } = await productController.activateSwitch(body);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "message": "Activation Secussfull"
}
```

#### Delete

delete

```ts
async delete(
  productId: number,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `productId` | `number` | Form, Required | takes product id product must be yours and id exixts |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const productId = 202;
try {
  const { result, ...httpResponse } = await productController.delete(productId);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "message": "Done"
}
```

#### Createproduct

create product

```ts
async createproduct(
  name: string,
  discription: string,
  price: number,
  category: string,
  image1: FileWrapper,
  ingredients: string[],
  alergicTo: string[],
  image2?: FileWrapper,
  image3?: FileWrapper,
  image4?: FileWrapper,
  image5?: FileWrapper,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `name` | `string` | Form, Required | - |
| `discription` | `string` | Form, Required | - |
| `price` | `number` | Form, Required | - |
| `category` | `string` | Form, Required | - |
| `image1` | `FileWrapper` | Form, Required | - |
| `ingredients` | `string[]` | Form, Required | It is an array you an add and update and ingredient on index |
| `alergicTo` | `string[]` | Form, Required | Which things in an array |
| `image2` | `FileWrapper \| undefined` | Form, Optional | - |
| `image3` | `FileWrapper \| undefined` | Form, Optional | - |
| `image4` | `FileWrapper \| undefined` | Form, Optional | - |
| `image5` | `FileWrapper \| undefined` | Form, Optional | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const name = 'name0';
const discription = 'discription2';
const price = 16;
const category = 'category2';
const image1 = new FileWrapper(fs.createReadStream('dummy_file'));
const Ingredients: string[] = ['ingredients6'];
const AlergicTo: string[] = ['alergic_to0'];
try {
  const { result, ...httpResponse } = await productController.createproduct(name, discription, price, category, image1, ingredients, alergicTo);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "message": "Operation Successfull",
  "errors": []
}
```

#### Custum Order

custum_order

```ts
async custumOrder(
  body: CustomOrderSwitchRequest,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CustomOrderSwitchRequest`](#custom-order-switch-request) | Body, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const body: CustomOrderSwitchRequest = {
  productId: 2,
  switch: true,
};

try {
  const { result, ...httpResponse } = await productController.custumOrder(body);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Update

update product

```ts
async update(
  body: ProductUpdateRequest,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`ProductUpdateRequest`](#product-update-request) | Body, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const body: ProductUpdateRequest = {
  name: 'change name',
  productId: '2',
  discription: 'change discription to somthing you want',
  price: '25',
  catagory: 'Product Catagory Name',
};

try {
  const { result, ...httpResponse } = await productController.update(body);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "message": "Opration Secussfull"
}
```

### Order

#### Order Details

<h2>output is</h2><br> <br> <br>
<code>
{<br>
    "seccuss": true,<br>
    "Order": [<br>
        {<br>
            "order_id": 2,<br>
            "order_uid": "934a43b9-ff4e-4c68-860c-3d8f6430f861",<br>
            "buyer_id": 1,<br>
            "total_products": 8,<br>
            "total_amount": 400,<br>
            "active": 1,<br>
            "canceled": 0,<br>
            "completed": 0,<br>
            "created_by": 1,<br>
            "deleted_at": null,<br>
            "m_delete": null,<br>
            "created_at": "2021-04-26 21:15:31",<br>
            "updated_at": "2021-04-26 21:15:31"<br>
        }<br>
    ],<br>
    "Order Details": [<br>
        {<br>
            "order_detail_id": 2,<br>
            "order_id": 2,<br>
            "product_category_id": null,<br>
            "product_category_item_id": null,<br>
            "custom": "Not allowed by product owner",<br>
            "item_price": 400,<br>
            "item_quantity": 8,<br>
            "created_by": 1,<br>
            "m_delete": null,<br>
            "created_at": "2021-04-26 21:15:31",<br>
            "updated_at": "2021-04-26 21:15:31"<br>
        }<br>
    ],<br>
    "Order Items": [<br>
        {<br>
            "id": 2,<br>
            "order_id": 2,<br>
            "product_id": 1,<br>
            "amount": 7,<br>
            "added_by": 1,<br>
            "created_at": "2021-04-26 21:15:31",<br>
            "updated_at": "2021-04-26 21:15:31"<br>
        },<br>
        {<br>
            "id": 3,<br>
            "order_id": 2,<br>
            "product_id": 1,<br>
            "amount": 1,<br>
            "added_by": 1,<br>
            "created_at": "2021-04-26 21:15:31",<br>
            "updated_at": "2021-04-26 21:15:31"<br>
        }<br>
    ]<br>
}<br>
</code>


```ts
async orderDetails(
  authorization?: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<OrderDetails>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `authorization` | `string \| undefined` | Header, Optional | **Default**: `'Bearer {token}'` |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

[`OrderDetails`](#order-details-1)

##### Example Usage

```ts
const authorization = 'Bearer {token}';
try {
  const { result, ...httpResponse } = await orderController.orderDetails(authorization);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response *(as JSON)*

```json
{
  "seccuss": true,
  "Order": [
    {
      "order_id": 2,
      "order_uid": "934a43b9-ff4e-4c68-860c-3d8f6430f861",
      "buyer_id": 1,
      "total_products": 8,
      "total_amount": 400,
      "active": 1,
      "canceled": 0,
      "completed": 0,
      "created_by": 1,
      "deleted_at": "null",
      "m_delete": "null",
      "created_at": "2021-04-26 21:15:31",
      "updated_at": "2021-04-26 21:15:31"
    }
  ],
  "Order Details": [
    {
      "order_detail_id": 2,
      "order_id": 2,
      "product_category_id": "null",
      "product_category_item_id": "null",
      "custom": "Not allowed by product owner",
      "item_price": 400,
      "item_quantity": 8,
      "created_by": 1,
      "m_delete": "null",
      "created_at": "2021-04-26 21:15:31",
      "updated_at": "2021-04-26 21:15:31"
    }
  ],
  "Order Items": [
    {
      "id": 2,
      "order_id": 2,
      "product_id": 1,
      "amount": 7,
      "added_by": 1,
      "created_at": "2021-04-26 21:15:31",
      "updated_at": "2021-04-26 21:15:31"
    },
    {
      "id": 3,
      "order_id": 2,
      "product_id": 1,
      "amount": 1,
      "added_by": 1,
      "created_at": "2021-04-26 21:15:31",
      "updated_at": "2021-04-26 21:15:31"
    }
  ]
}
```

#### Cancelorder

cancel order

```ts
async cancelorder(
  orderUid: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderUid` | `string` | Form, Required | can get from order details |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const orderUid = 'order_uid8';
try {
  const { result, ...httpResponse } = await orderController.cancelorder(orderUid);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Accept

accept

```ts
async accept(
  orderUid: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderUid` | `string` | Form, Required | can get from order details |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const orderUid = 'order_uid8';
try {
  const { result, ...httpResponse } = await orderController.accept(orderUid);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Place Order

In the product array  request will take multiple objects to make order of multiple items

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>
<table class="tg">
<thead>
  <tr>
    <th class="tg-0lax">Response Code</th>
    <th class="tg-0lax">Response</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg-0lax">200</td>
    <td class="tg-0lax">{
    "message": "Order Placed"
}</td>
  </tr>
  <tr>
    <td class="tg-0lax">401</td>
    <td class="tg-0lax">{
    "error": "You are Unauthanticated"
}</td>
  </tr>
  <tr>
    <td class="tg-0lax">500</td>
    <td class="tg-0lax">{
    "Error": "Internal Server Error"
}</td>
  </tr>
</tbody>
</table>


```ts
async placeOrder(
  body: PlaceOrderRequest,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`PlaceOrderRequest`](#place-order-request) | Body, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const bodyProduct: Product[] = [];

const bodyproduct0: Product = {
  productId: '1',
  amount: '7',
  custom: ' extra chese',
};

bodyProduct[0] = bodyproduct0;

const bodyproduct1: Product = {
  productId: '1',
  amount: '1',
  custom: ' extra chese',
};

bodyProduct[1] = bodyproduct1;

const body: PlaceOrderRequest = {
  product: bodyProduct,
};

try {
  const { result, ...httpResponse } = await orderController.placeOrder(body);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Shop Orders

All of you orders

```ts
async shopOrders(
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
try {
  const { result, ...httpResponse } = await orderController.shopOrders();
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "order_detail": [
    {
      "order_id": 8,
      "order_uid": "93672792-5446-4b78-a546-69fdf6c5b2c8",
      "buyer_id": 1,
      "active": 1,
      "canceled": 0,
      "completed": 0,
      "created_at": "2021-05-11 05:55:48"
    }
  ],
  "details": {
    "0": {
      "custom": "Not allowed by product owner"
    },
    "TotalPrice": 400
  },
  "items": [
    {
      "order_id": 8,
      "product_id": 1,
      "shop_id": 1,
      "amount": 7,
      "total_price": 350
    },
    {
      "order_id": 8,
      "product_id": 1,
      "shop_id": 1,
      "amount": 1,
      "total_price": 50
    }
  ]
}
```

#### Placed Order

The order which you placed to other stores

```ts
async placedOrder(
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
try {
  const { result, ...httpResponse } = await orderController.placedOrder();
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "order_detail": [
    {
      "order_id": 2,
      "order_uid": "934a43b9-ff4e-4c68-860c-3d8f6430f861",
      "buyer_id": 1,
      "total_amount": 400,
      "active": 1,
      "canceled": 0,
      "completed": 0,
      "created_at": "2021-04-26 21:15:31"
    },
    {
      "order_id": 3,
      "order_uid": "9350eaae-9cde-4ddd-872c-75b387c3a6b3",
      "buyer_id": 1,
      "total_amount": 400,
      "active": 1,
      "canceled": 0,
      "completed": 0,
      "created_at": "2021-04-30 04:37:20"
    },
    {
      "order_id": 8,
      "order_uid": "93672792-5446-4b78-a546-69fdf6c5b2c8",
      "buyer_id": 1,
      "total_amount": 400,
      "active": 1,
      "canceled": 0,
      "completed": 0,
      "created_at": "2021-05-11 05:55:48"
    }
  ],
  "details": [
    {
      "custom": "Not allowed by product owner"
    }
  ],
  "items": [
    {
      "order_id": 2,
      "product_id": 1,
      "shop_id": 0,
      "amount": 7,
      "total_price": 0
    },
    {
      "order_id": 2,
      "product_id": 1,
      "shop_id": 0,
      "amount": 1,
      "total_price": 0
    }
  ]
}
```

### Review

#### Postreviws

post reviews for an order for each product in order

```ts
async postreviws(
  reviewsObject: ReviewRequests,
  requestOptions?: RequestOptions
): Promise<ApiResponse<string>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `reviewsObject` | [`ReviewRequests`](#review-requests) | Body, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`string`

##### Example Usage

```ts
const reviewsObjectReviews: Reviews1[] = [];

const reviewsObjectreviews0: Reviews1 = {
  review: 5,
  comment: 'Nice Food and vary clean setup blah blah',
  productId: 1,
};

reviewsObjectReviews[0] = reviewsObjectreviews0;

const reviewsObjectreviews1: Reviews1 = {
  review: 5,
  comment: 'Nice Food and vary clean setup blah blah2',
  productId: 1,
};

reviewsObjectReviews[1] = reviewsObjectreviews1;

const reviewsObject: ReviewRequests = {
  orderUid: '9350eaae-9cde-4ddd-872c-75b387c3a6b3',
  reviews: reviewsObjectReviews,
};

try {
  const { result, ...httpResponse } = await reviewController.postreviws(reviewsObject);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
"review submitted"
```

##### Errors

| HTTP Status Code | Error Description | Exception Class |
|  --- | --- | --- |
| 400 | bad request | `ApiError` |

### Message

#### Recivemessage

recive message

```ts
async recivemessage(
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
try {
  const { result, ...httpResponse } = await messageController.recivemessage();
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Sendmessage

send message

```ts
async sendmessage(
  message: string,
  for: number,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `message` | `string` | Form, Required | - |
| `for` | `number` | Form, Required | user id you want to send message |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const message = 'message0';
const for = 170;
try {
  const { result, ...httpResponse } = await messageController.sendmessage(message, for);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

### Admin

#### Overview

this request only send by the those users who has and admin role and the admin role can be set on the model users column role which is by default new on the creation of an user account

#### Reports

reports

```ts
async reports(
  authorization?: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `authorization` | `string \| undefined` | Header, Optional | **Default**: `'Bearer {token}'` |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const authorization = 'Bearer {token}';
try {
  const { result, ...httpResponse } = await adminController.reports(authorization);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Deleteuser

delete user

```ts
async deleteuser(
  userId: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<string>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `userId` | `string` | Template, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`string`

##### Example Usage

```ts
const userId = 'user_id8';
try {
  const { result, ...httpResponse } = await adminController.deleteuser(userId);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
"user deleted"
```

#### Createcatagory

create catagory

```ts
async createcatagory(
  name: string,
  discription: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `name` | `string` | Form, Required | - |
| `discription` | `string` | Form, Required | minimum 20 chars |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const name = 'name0';
const discription = 'discription2';
try {
  const { result, ...httpResponse } = await adminController.createcatagory(name, discription);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Nummberofusers

nummber of users

```ts
async nummberofusers(
  authorization?: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `authorization` | `string \| undefined` | Header, Optional | **Default**: `'Bearer {token}'` |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const authorization = 'Bearer {token}';
try {
  const { result, ...httpResponse } = await adminController.nummberofusers(authorization);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

#### Cancel Order

cancel_order

```ts
async cancelOrder(
  orderUid: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderUid` | `string` | Form, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const orderUid = 'order_uid8';
try {
  const { result, ...httpResponse } = await adminController.cancelOrder(orderUid);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

### Misc

#### Searchproduct

this data already come paginated

:information_source: **Note** This endpoint does not require authentication.

```ts
async searchproduct(
  query: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<unknown>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `query` | `string` | Template, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`unknown`

##### Example Usage

```ts
const query = 'query0';
try {
  const { result, ...httpResponse } = await miscController.searchproduct(query);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

##### Example Response

```
{
  "current_page": 1,
  "data": [
    {
      "product_category_item_id": 1,
      "product_category_item_name": "tests",
      "product_category_item_description": "ewrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr",
      "product_category_item_price": 50,
      "custom_order": 0,
      "active": 0,
      "list_ingredients": 0,
      "is_allergic": "[\"okqwqw\"]",
      "product_uid": "934a4335-ff8a-4a2b-b993-a6b88a04d3b7",
      "m_delete": null,
      "product_category_id": 1,
      "product_image_id": null,
      "added_by": 1,
      "created_at": "2021-04-26 21:14:04",
      "updated_at": "2021-04-26 21:14:04"
    },
    {
      "product_category_item_id": 2,
      "product_category_item_name": "tests",
      "product_category_item_description": "ewrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr",
      "product_category_item_price": 50,
      "custom_order": 0,
      "active": 0,
      "list_ingredients": 0,
      "is_allergic": "[\"okqwqw\"]",
      "product_uid": "934c5023-f73c-440c-b780-8412548cec79",
      "m_delete": null,
      "product_category_id": 1,
      "product_image_id": null,
      "added_by": 1,
      "created_at": "2021-04-27 21:41:53",
      "updated_at": "2021-04-27 21:41:53"
    }
  ],
  "first_page_url": "http://127.0.0.1:5000/api/search/s?page=1",
  "from": 1,
  "last_page": 1,
  "last_page_url": "http://127.0.0.1:5000/api/search/s?page=1",
  "links": [
    {
      "url": null,
      "label": "&laquo; Previous",
      "active": false
    },
    {
      "url": "http://127.0.0.1:5000/api/search/s?page=1",
      "label": "1",
      "active": true
    },
    {
      "url": null,
      "label": "Next &raquo;",
      "active": false
    }
  ],
  "next_page_url": null,
  "path": "http://127.0.0.1:5000/api/search/s",
  "per_page": 15,
  "prev_page_url": null,
  "to": 2,
  "total": 2
}
```

#### Reportuser

report user

```ts
async reportuser(
  username: string,
  message: string,
  requestOptions?: RequestOptions
): Promise<ApiResponse<void>>
```

##### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `username` | `string` | Form, Required | - |
| `message` | `string` | Form, Required | - |
| `requestOptions` | `RequestOptions \| undefined` | Optional | Pass additional request options. |

##### Response Type

`void`

##### Example Usage

```ts
const username = 'username0';
const message = 'message0';
try {
  const { result, ...httpResponse } = await miscController.reportuser(username, message);
  // Get more response info...
  // const { statusCode, headers } = httpResponse;
} catch(error) {
  if (error instanceof ApiError) {
    const errors = error.result;
    // const { statusCode, headers } = error;
  }
}
```

## Model Reference

### Structures

* [Loginrequest](#loginrequest)
* [Updateprofilerequest](#updateprofilerequest)
* [Resetpasswordrequest](#resetpasswordrequest)
* [Product](#product-1)
* [Order Details](#order-details-1)
* [Order Item](#order-item)
* [Order](#order-1)
* [Place Order Request](#place-order-request)
* [Activate Switch Request](#activate-switch-request)
* [Order Details 1](#order-details-1)
* [Custom Order Switch Request](#custom-order-switch-request)
* [Product Update Request](#product-update-request)
* [Reviews](#reviews)
* [Reviews 1](#reviews-1)
* [Review Requests](#review-requests)

#### Loginrequest

##### Class Name

`Loginrequest`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `username` | `string` | Required | - |
| `password` | `string` | Required | - |

##### Example (as JSON)

```json
{
  "username": "user23",
  "password": "1234564"
}
```

#### Updateprofilerequest

##### Class Name

`Updateprofilerequest`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `name` | `string` | Required | - |
| `description` | `string` | Required | - |
| `typeOfBusiness` | `string` | Required | - |
| `phone` | `string` | Required | - |
| `email` | `string` | Required | - |
| `halal` | `string` | Required | - |

##### Example (as JSON)

```json
{
  "name": "test2",
  "Description": "This is my store contains this this and this ",
  "Type_of_Business": "Restaurant",
  "Phone": "+923001234567",
  "email": "test3@gmail.com",
  "halal": "1"
}
```

#### Resetpasswordrequest

##### Class Name

`Resetpasswordrequest`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `token` | `string` | Required | - |
| `email` | `string` | Required | - |
| `password` | `string` | Required | - |

##### Example (as JSON)

```json
{
  "token": "3eee3f340765df16d84d6c28dfdfa4b4e435c619e35d7b12e324dfd54a225e3d",
  "email": "saifullahsaeed05@gmail.com",
  "password": "pakistan"
}
```

#### Product

##### Class Name

`Product`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `productId` | `string` | Required | - |
| `amount` | `string` | Required | - |
| `custom` | `string` | Required | - |

##### Example (as JSON)

```json
{
  "product_id": "1",
  "amount": "7",
  "custom": " extra chese"
}
```

#### Order Details

##### Class Name

`OrderDetails`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `seccuss` | `boolean` | Required | - |
| `order` | [`Order[]`](#order-1) | Required | - |
| `orderDetails` | [`OrderDetails1[]`](#order-details-1) | Required | - |
| `orderItems` | [`OrderItem[]`](#order-item) | Required | - |

##### Example (as JSON)

```json
{
  "seccuss": true,
  "Order": [
    {
      "order_id": 2,
      "order_uid": "934a43b9-ff4e-4c68-860c-3d8f6430f861",
      "buyer_id": 1,
      "total_products": 8,
      "total_amount": 400,
      "active": 1,
      "canceled": 0,
      "completed": 0,
      "created_by": 1,
      "deleted_at": "null",
      "m_delete": "null",
      "created_at": "2021-04-26 21:15:31",
      "updated_at": "2021-04-26 21:15:31"
    }
  ],
  "Order Details": [
    {
      "order_detail_id": 2,
      "order_id": 2,
      "product_category_id": "null",
      "product_category_item_id": "null",
      "custom": "Not allowed by product owner",
      "item_price": 400,
      "item_quantity": 8,
      "created_by": 1,
      "m_delete": "null",
      "created_at": "2021-04-26 21:15:31",
      "updated_at": "2021-04-26 21:15:31"
    }
  ],
  "Order Items": [
    {
      "id": 2,
      "order_id": 2,
      "product_id": 1,
      "amount": 7,
      "added_by": 1,
      "created_at": "2021-04-26 21:15:31",
      "updated_at": "2021-04-26 21:15:31"
    },
    {
      "id": 3,
      "order_id": 2,
      "product_id": 1,
      "amount": 1,
      "added_by": 1,
      "created_at": "2021-04-26 21:15:31",
      "updated_at": "2021-04-26 21:15:31"
    }
  ]
}
```

#### Order Item

##### Class Name

`OrderItem`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `number` | Required | - |
| `orderId` | `number` | Required | - |
| `productId` | `number` | Required | - |
| `amount` | `number` | Required | - |
| `addedBy` | `number` | Required | - |
| `createdAt` | `string` | Required | - |
| `updatedAt` | `string` | Required | - |

##### Example (as JSON)

```json
{
  "id": 2,
  "order_id": 2,
  "product_id": 1,
  "amount": 7,
  "added_by": 1,
  "created_at": "2021-04-26 21:15:31",
  "updated_at": "2021-04-26 21:15:31"
}
```

#### Order

##### Class Name

`Order`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderId` | `number` | Required | - |
| `orderUid` | `string` | Required | - |
| `buyerId` | `number` | Required | - |
| `totalProducts` | `number` | Required | - |
| `totalAmount` | `number` | Required | - |
| `active` | `number` | Required | - |
| `canceled` | `number` | Required | - |
| `completed` | `number` | Required | - |
| `createdBy` | `number` | Required | - |
| `deletedAt` | `string` | Required | - |
| `mDelete` | `string` | Required | - |
| `createdAt` | `string` | Required | - |
| `updatedAt` | `string` | Required | - |

##### Example (as JSON)

```json
{
  "order_id": 2,
  "order_uid": "934a43b9-ff4e-4c68-860c-3d8f6430f861",
  "buyer_id": 1,
  "total_products": 8,
  "total_amount": 400,
  "active": 1,
  "canceled": 0,
  "completed": 0,
  "created_by": 1,
  "deleted_at": "null",
  "m_delete": "null",
  "created_at": "2021-04-26 21:15:31",
  "updated_at": "2021-04-26 21:15:31"
}
```

#### Place Order Request

##### Class Name

`PlaceOrderRequest`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `product` | [`Product[]`](#product-1) | Required | - |

##### Example (as JSON)

```json
{
  "product": [
    {
      "product_id": "1",
      "amount": "7",
      "custom": " extra chese"
    },
    {
      "product_id": "1",
      "amount": "1",
      "custom": " extra chese"
    }
  ]
}
```

#### Activate Switch Request

##### Class Name

`ActivateSwitchRequest`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `productId` | `number` | Required | - |
| `switch` | `boolean` | Required | - |

##### Example (as JSON)

```json
{
  "product_id": 2,
  "switch": true
}
```

#### Order Details 1

##### Class Name

`OrderDetails1`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderDetailId` | `number` | Required | - |
| `orderId` | `number` | Required | - |
| `productCategoryId` | `string` | Required | - |
| `productCategoryItemId` | `string` | Required | - |
| `custom` | `string` | Required | - |
| `itemPrice` | `number` | Required | - |
| `itemQuantity` | `number` | Required | - |
| `createdBy` | `number` | Required | - |
| `mDelete` | `string` | Required | - |
| `createdAt` | `string` | Required | - |
| `updatedAt` | `string` | Required | - |

##### Example (as JSON)

```json
{
  "order_detail_id": 2,
  "order_id": 2,
  "product_category_id": "null",
  "product_category_item_id": "null",
  "custom": "Not allowed by product owner",
  "item_price": 400,
  "item_quantity": 8,
  "created_by": 1,
  "m_delete": "null",
  "created_at": "2021-04-26 21:15:31",
  "updated_at": "2021-04-26 21:15:31"
}
```

#### Custom Order Switch Request

##### Class Name

`CustomOrderSwitchRequest`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `productId` | `number` | Required | - |
| `switch` | `boolean` | Required | - |

##### Example (as JSON)

```json
{
  "product_id": 202,
  "switch": false
}
```

#### Product Update Request

##### Class Name

`ProductUpdateRequest`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `name` | `string` | Required | - |
| `productId` | `string` | Required | - |
| `discription` | `string` | Required | - |
| `price` | `string` | Required | - |
| `catagory` | `string` | Required | - |

##### Example (as JSON)

```json
{
  "name": "change name",
  "product_id": "2",
  "discription": "change discription to somthing you want",
  "price": "25",
  "catagory": "Product Catagory Name"
}
```

#### Reviews

##### Class Name

`Reviews`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderUid` | `string` | Required | - |
| `reviews` | [`Reviews1[]`](#reviews-1) | Required | - |

##### Example (as JSON)

```json
{
  "order_uid": "9350eaae-9cde-4ddd-872c-75b387c3a6b3",
  "reviews": [
    {
      "review": 5,
      "comment": "Nice Food and vary clean setup blah blah",
      "product_id": 1
    },
    {
      "review": 5,
      "comment": "Nice Food and vary clean setup blah blah2",
      "product_id": 1
    }
  ]
}
```

#### Reviews 1

##### Class Name

`Reviews1`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `review` | `number` | Required | - |
| `comment` | `string` | Required | - |
| `productId` | `number` | Required | - |

##### Example (as JSON)

```json
{
  "review": 5,
  "comment": "Nice Food and vary clean setup blah blah",
  "product_id": 1
}
```

#### Review Requests

##### Class Name

`ReviewRequests`

##### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderUid` | `string` | Required | order uid |
| `reviews` | [`Reviews1[]`](#reviews-1) | Required | - |

##### Example (as JSON)

```json
{
  "order_uid": "9350eaae-9cde-4ddd-872c-75b387c3a6b3",
  "reviews": {
    "review": 5,
    "comment": "Nice Food and vary clean setup blah blah",
    "product_id": 1
  }
}
```

## Common Code Documentation

### ApiResponse

An interface for the result of an API call.

#### Properties

| Name | Type | Description |
|  --- | --- | --- |
| request | HttpRequest | Original request that resulted in this response. |
| statusCode | number | Response status codee. |
| headers | Record<string, string> | Response headers. |
| result | T | Response data. |
| body | string \| Blob \| NodeJS.ReadableStream | Original body from the response. |

### ApiError

Thrown when the HTTP status code is not okay.

The ApiError extends the ApiResponse interface, so all ApiResponse properties are available.

#### Properties

| Name | Type | Description |
|  --- | --- | --- |
| request | HttpRequest | Original request that resulted in this response. |
| statusCode | number | Response status codee. |
| headers | Record<string, string> | Response headers. |
| result | T | Response data. |
| body | string \| Blob \| NodeJS.ReadableStream | Original body from the response. |

