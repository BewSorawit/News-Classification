from datetime import datetime, timezone
from sqlalchemy.orm import Session
from schemas.category import CategoryCreate
from crud.categories import create_category, get_category_by_name
from crud.news_type import get_news_type_by_status
from models.news import News
from schemas.news import NewsCreate, NewsResponse
from models.news_type import StatusEnum


def create_news(db: Session, news: NewsCreate, writer_id: int) -> NewsResponse:

    news_type = get_news_type_by_status(db, StatusEnum.upload)

    category_level_1 = get_category_by_name(db, "news_category1")
    if category_level_1 is None:
        category_level_1 = create_category(
            db, CategoryCreate(name="news_category1"))

    category_level_2 = get_category_by_name(db, "news_category2")
    if category_level_2 is None:
        category_level_2 = create_category(
            db, CategoryCreate(name="news_category2"))

    news_item = News(
        title=news.title,
        content=news.content,
        writer_id=writer_id,
        news_type_id=news_type.id,
        category_level_1=category_level_1.id,
        category_level_2=category_level_2.id,
        upload_date=datetime.now(timezone.utc),
    )
    db.add(news_item)
    db.commit()
    db.refresh(news_item)
    return news_item
