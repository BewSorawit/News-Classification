from datetime import datetime, timezone
from fastapi import HTTPException, status
from sqlalchemy.orm import Session
from crud.news_type import get_news_type_by_status
from models.news import News
from schemas.news import NewsCreate, NewsResponse
from models.news_type import StatusEnum


def create_news(db: Session, news: NewsCreate, writer_id: int) -> NewsResponse:
    news_type = get_news_type_by_status(db, StatusEnum.upload)
    news_item = News(
        title=news.title,
        content=news.content,
        writer_id=writer_id,
        news_type_id=news_type.id,
        category_level_1="sdsd",
        # category_level_2=news.category_level_2,
        upload_date=datetime.now(timezone.utc),
    )
    db.add(news_item)
    db.commit()
    db.refresh(news_item)
    return news_item
