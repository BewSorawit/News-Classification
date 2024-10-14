from pydantic import BaseModel, EmailStr
from typing import Optional


class TyperUserBase(BaseModel):
    role: str


class TyperUserResponse(TyperUserBase):
    id: int

    class Config:
        from_attributes = True
