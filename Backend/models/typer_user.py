from sqlalchemy import Column, Integer, Enum
from sqlalchemy.orm import relationship
from database import Base
from enum import Enum as PyEnum


class RoleEnum(PyEnum):
    admin = "admin"
    editor = "editor"
    writer = "writer"
    viewer = "viewer"


class TyperUser(Base):
    __tablename__ = "typer_users"

    id = Column(Integer, primary_key=True, index=True)
    role = Column(Enum(RoleEnum), index=True)

    users = relationship("User", back_populates="typer_user")
