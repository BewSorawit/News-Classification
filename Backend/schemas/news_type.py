from datetime import datetime
from pydantic import BaseModel, EmailStr
from typing import Optional


class NewsType(BaseModel):
    status: str


class NewsTypeResponse(NewsType):
    id: int

    class Config:
        from_attributes = True
