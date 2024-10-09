from sqlalchemy.orm import Session
from fastapi import HTTPException, status
from models.news import News
from schemas.news import NewsCreate, NewsResponse
from models.news_type import NewsType, StatusEnum


def get_news_type_by_status(db: Session, status: StatusEnum) -> NewsType:
    news_type = db.query(NewsType).filter(NewsType.status == status).first()
    if not news_type:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail=f"News type '{status}' not found."
        )
    return news_type
