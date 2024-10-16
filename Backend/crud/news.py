from datetime import datetime, timezone
from typing import Optional
from fastapi import HTTPException, status
from sqlalchemy.orm import Session
from schemas.category import CategoryCreate
from crud.categories import create_category, get_category_by_name
from crud.news_type import get_news_type_by_status
from models.news import News
from schemas.news import NewsCreate, NewsUpdate
from models.news_type import NewsType, StatusEnum
from crud.NewsClassification import predictByBjk


def create_news(db: Session, news: NewsCreate, writer_id: int) -> News:

    data = news.title+' . '+news.content
    pred = predictByBjk(data)
    print("pred",pred)

    news_type = get_news_type_by_status(db, StatusEnum.upload)

    category_level_1 = get_category_by_name(db, pred[0])
    if category_level_1 is None:
        category_level_1 = create_category(
            db, CategoryCreate(name=pred[0]))

    category_level_2 = get_category_by_name(db, pred[1])
    if category_level_2 is None:
        category_level_2 = create_category(
            db, CategoryCreate(name=pred[1]))

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


def update_news(db: Session, news_id: int, news_update: NewsUpdate, editor_id: int) -> News:
    news_item = db.query(News).filter(News.id == news_id).first()

    if not news_item:
        raise HTTPException(status_code=404, detail="News item not found")

    news_item.editor_id = editor_id

    news_type = db.query(NewsType).filter(
        NewsType.id == news_update.news_type_id).first()

    if news_type is None:
        raise HTTPException(status_code=404, detail="News type not found")

    if news_type.status not in [StatusEnum.public, StatusEnum.unapprove]:
        raise HTTPException(status_code=400, detail="Invalid news type status")

    news_item.news_type_id = news_update.news_type_id

    if news_update.reason or news_update.category_level_1 or news_update.category_level_2 or news_item.news_type_id:
        news_item.verify_date = datetime.now(timezone.utc)

    if news_update.reason is not None:
        news_item.reason = news_update.reason
    if news_update.category_level_1 is not None:
        news_item.category_level_1 = news_update.category_level_1
    if news_update.category_level_2 is not None:
        news_item.category_level_2 = news_update.category_level_2

    db.commit()
    db.refresh(news_item)
    return news_item



def getAll(db: Session,) -> News:
    return db.query(News).all()


def getByType(db: Session, news_type_id) -> News:
    return db.query(News).filter(News.news_type_id == news_type_id).all()


def getByTypeEditor(db: Session, news_type_id, usid) -> News:
    return db.query(News).filter(News.news_type_id == news_type_id).filter(News.editor_id == usid).all()


def getNewsById(db: Session, news_id) -> News:
    news = db.query(News).filter(News.id == news_id).first()

    if not news:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="News not found"
        )

    return news


def writerGetAll(db: Session, writer_id: Optional[int] = None):
    query = db.query(News)
    if writer_id is not None:
        query = query.filter(News.writer_id == writer_id)
    return query.all()


def getByTypeEditor(db: Session, news_type_id, usid) -> News:
    return db.query(News).filter(News.news_type_id == news_type_id).filter(News.editor_id == usid).all()