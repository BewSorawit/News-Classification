from datetime import datetime
from pydantic import BaseModel, EmailStr
from typing import Optional


class NewsBase(BaseModel):
    title: str
    content: str


class NewsCreate(NewsBase):
    pass


class NewsUpdate(NewsBase):

    reason: Optional[str] = None


class NewsResponse(BaseModel):
    id: int
    title: str
    content: str
    writer_id: int
    editor_id: Optional[int] = None
    news_type_id: int
    upload_date: datetime
    verify_date: Optional[datetime] = None
    category_level_1: str
    category_level_2: Optional[str] = None
    reason: Optional[str] = None

    class Config:
        from_attributes = True


class NewsCreatedDataResponse(BaseModel):
    id: int
    title: str
    content: str
    upload_date: datetime

    class Config:
        from_attributes = True


class NewsCreatedResponse(BaseModel):
    success: bool
    data: NewsCreatedDataResponse
