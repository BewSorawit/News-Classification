from sqlalchemy import Column, Integer, Enum
from sqlalchemy.orm import relationship
from database import Base
from enum import Enum as PyEnum


class StatusEnum(PyEnum):
    upload = "upload"
    public = "public"
    unapprove = "unapprove"


class NewsType(Base):
    __tablename__ = "news_types"

    id = Column(Integer, primary_key=True, index=True)
    status = Column(Enum(StatusEnum), index=True)

    news = relationship("News", back_populates="news_type")
