from sqlalchemy import Column, Integer, String, ForeignKey, DateTime, Text
from sqlalchemy.orm import relationship
from datetime import datetime, timezone
from database import Base


class News(Base):
    __tablename__ = "news"

    id = Column(Integer, primary_key=True, index=True)
    title = Column(Text, index=True)
    content = Column(Text, index=True)
    reason = Column(Text, index=True, nullable=True)
    writer_id = Column(Integer, ForeignKey("users.id"))
    editor_id = Column(Integer, ForeignKey("users.id"), nullable=True)
    news_type_id = Column(Integer, ForeignKey("news_types.id"))

    upload_date = Column(DateTime, default=datetime.now(
        timezone.utc))
    verify_date = Column(DateTime, default=None, nullable=True)

    category_level_1 = Column(Integer, ForeignKey("categories.id"))
    category_level_2 = Column(
        Integer, ForeignKey("categories.id"), nullable=True)

    writer = relationship("User", foreign_keys=[
                          writer_id], back_populates="written_news")
    editor = relationship("User", foreign_keys=[
                          editor_id], back_populates="edited_news")
    news_type = relationship("NewsType", back_populates="news")

    category_1 = relationship("Category", foreign_keys=[category_level_1])
    category_2 = relationship("Category", foreign_keys=[category_level_2])
