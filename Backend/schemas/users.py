from pydantic import BaseModel


class UserBase(BaseModel):
    username: str
    email: str
    typer_user_id: int


class UserCreate(UserBase):
    password: str


class UserUpdate(UserBase):
    password: str


class User(UserBase):
    id: int

    class Config:
        orm_mode = True
