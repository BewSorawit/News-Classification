from sqlalchemy import Column, Integer, String, ForeignKey, DateTime
from sqlalchemy.orm import relationship
from datetime import datetime
from database import Base


class News(Base):
    __tablename__ = "news"

    id = Column(Integer, primary_key=True, index=True)
    title = Column(String(255), index=True)
    content = Column(String(255), index=True)
    reason = Column(String(255), index=True)
    writer_id = Column(Integer, ForeignKey("users.id"))
    editor_id = Column(Integer, ForeignKey("users.id"), nullable=True)
    news_type_id = Column(Integer, ForeignKey("news_types.id"))

    upload_date = Column(DateTime, default=datetime.utcnow, nullable=True)
    verify_date = Column(DateTime, default=None, nullable=True)
    categories = Column(String(255), index=True)

    writer = relationship("User", foreign_keys=[
                          writer_id], back_populates="written_news")
    editor = relationship("User", foreign_keys=[
                          editor_id], back_populates="edited_news")
    news_type = relationship("NewsType", back_populates="news")
